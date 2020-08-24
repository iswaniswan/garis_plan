<?php
    /**
     * Created by PhpStorm.
     * User: miroslav
     * Date: 23/04/2019
     * Time: 09:00
     */

    namespace Ataccama\Utils;


    use Ataccama\Adapters\Keycloak;
    use Ataccama\Adapters\KeycloakExtended;
    use Ataccama\Clients\Keycloak\Env\Users\User;
    use Ataccama\Exceptions\CurlException;
    use Ataccama\Exceptions\UnknownError;


    /**
     * Class KeycloakAPI
     * @package Ataccama\Utils
     */
    class KeycloakAPI
    {
        /**
         * @param Keycloak $keycloak
         * @param string   $authorizationCode
         * @return AuthorizationResponse
         * @throws CurlException
         * @throws UnknownError
         */
        public static function getAuthorization(Keycloak $keycloak, string $authorizationCode): AuthorizationResponse
        {
            $response = Curl::post("$keycloak->host/auth/realms/$keycloak->realmId/protocol/openid-connect/token", [
                "Content-Type" => "application/x-www-form-urlencoded"
            ], [
                'grant_type'   => 'authorization_code',
                'code'         => $authorizationCode,
                'client_id'    => $keycloak->clientId,
                'redirect_uri' => $keycloak->redirectUri
            ]);

            if (isset($response->body->error)) {
                throw new CurlException($response->body->error . ": " . $response->body->error_description);
            }

            if (isset($response->body->access_token)) {
                return new AuthorizationResponse($response->body);
            }

            throw new UnknownError("???");
        }

        /**
         * @param KeycloakExtended $keycloak
         * @return AuthorizationResponse
         * @throws CurlException
         * @throws UnknownError
         */
        public static function getApiAuthorization(KeycloakExtended $keycloak): AuthorizationResponse
        {
            $response = Curl::post("$keycloak->host/auth/realms/$keycloak->realmId/protocol/openid-connect/token", [
                "Content-Type" => "application/x-www-form-urlencoded"
            ], [
                'grant_type'    => 'password',
                'client_id'     => $keycloak->apiClientId,
                'client_secret' => $keycloak->apiClientSecret,
                'username'      => $keycloak->apiUsername,
                'password'      => $keycloak->apiPassword
            ]);

            if (isset($response->body->error)) {
                throw new CurlException($response->body->error . ": " . $response->body->error_description);
            }

            if (isset($response->body->access_token)) {
                return new AuthorizationResponse($response->body);
            }

            throw new UnknownError("???");
        }

        /**
         * @param KeycloakExtended $keycloak
         * @param string           $username
         * @param string           $firstname
         * @param string           $lastname
         * @param string           $email
         * @param bool             $enabled
         * @param array            $groups
         * @return bool
         * @throws CurlException
         */
        public static function createUser(
            KeycloakExtended $keycloak,
            string $username,
            string $firstname,
            string $lastname,
            string $email,
            bool $enabled = true,
            array $groups = ['default-group']
        ): bool {
            $response = Curl::post("$keycloak->host/auth/admin/realms/$keycloak->realmId/users", [
                "Content-Type"  => "application/json",
                "Authorization" => "Bearer " . $keycloak->apiAccessToken->bearer
            ], json_encode([
                'username'  => $username,
                'firstName' => $firstname,
                'lastName'  => $lastname,
                "email"     => $email,
                "enabled"   => $enabled,
                "groups"    => $groups
            ]));

            if ($response->code == 201) {
                return true;
            }

            throw new CurlException("User creation failed. HTTP response code: $response->code");
        }

        /**
         * @param KeycloakExtended $keycloak
         * @param string           $email
         * @return User
         * @throws CurlException
         */
        public static function getUserByEmail(
            KeycloakExtended $keycloak,
            string $email
        ): User {
            $response = Curl::get("$keycloak->host/auth/admin/realms/$keycloak->realmId/users?email=$email", [
                "Content-Type"  => "application/json",
                "Authorization" => "Bearer " . $keycloak->apiAccessToken->bearer
            ]);

            if ($response->code == 200) {
                foreach ($response->body as $user) {
                    if ($user->email == $email) {
                        return new User($user->id, $user->firstName, $user->lastName, $user->email);
                    }
                }
            }

            throw new CurlException("Getting user by email failed. HTTP response code: $response->code ($response->error)");
        }

        /**
         * @param Keycloak     $keycloak
         * @param RefreshToken $userRefreshToken
         * @return AuthorizationResponse
         * @throws CurlException
         * @throws UnknownError
         */
        public static function reauthorize(Keycloak $keycloak, RefreshToken $userRefreshToken): AuthorizationResponse
        {
            $response = Curl::post("$keycloak->host/auth/realms/$keycloak->realmId/protocol/openid-connect/token", [
                "Content-Type" => "application/x-www-form-urlencoded"
            ], [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $userRefreshToken->refreshToken,
                'client_id'     => $keycloak->clientId,
                'redirect_uri'  => $keycloak->redirectUri
            ]);

            if (isset($response->body->error)) {
                throw new CurlException($response->body->error . ": " . $response->body->error_description);
            }

            if (isset($response->body->access_token)) {
                return new AuthorizationResponse($response->body);
            }

            throw new UnknownError("???");
        }

        /**
         * @param Keycloak     $keycloak
         * @param RefreshToken $userRefreshToken
         * @return bool
         * @throws CurlException
         */
        public static function logout(Keycloak $keycloak, RefreshToken $userRefreshToken): bool
        {
            $response = Curl::post("$keycloak->host/auth/realms/$keycloak->realmId/protocol/openid-connect/logout", [
                "Content-Type" => "application/x-www-form-urlencoded"
            ], [
                "refresh_token" => $userRefreshToken->refreshToken,
                "client_id"     => $keycloak->clientId
            ]);

            if ($response->code == 200 || $response->code == 204) {
                return true;
            }

            if (isset($response->body->error)) {
                throw new CurlException("HTTP $response->code: " . $response->body->error . ": " .
                    $response->body->error_description);
            } else {
                throw new CurlException("HTTP $response->code: " . $response->error);
            }
        }

        public static function userExists(KeycloakExtended $keycloak, string $email): bool
        {
            $response = Curl::get("$keycloak->host/auth/admin/realms/$keycloak->realmId/users?email=$email", [
                "Authorization" => "Bearer " . $keycloak->apiAccessToken->bearer
            ]);

            if (isset($response->body[0]->username)) {
                return ($email == $response->body[0]->username);
            }

            return false;
        }

        /**
         * @param KeycloakExtended $keycloak
         * @param string           $keycloakId
         * @param string           $password
         * @param bool             $temporary
         * @return bool
         * @throws CurlException
         */
        public static function setPassword(
            KeycloakExtended $keycloak,
            string $keycloakId,
            string $password,
            bool $temporary = false
        ) {
            $response = Curl::put("$keycloak->host/auth/admin/realms/$keycloak->realmId/users/$keycloakId/reset-password",
                [
                    "Content-Type"  => "application/json",
                    "Authorization" => "Bearer " . $keycloak->apiAccessToken->bearer,
                ], json_encode([
                    "temporary" => $temporary,
                    "type"      => "password",
                    "value"     => $password
                ]));

            if ($response->code == 204) {
                return true;
            }

            if (isset($response->body->error)) {
                throw new CurlException("HTTP $response->code: " . $response->body->error . ": " .
                    $response->body->error_description);
            } else {
                throw new CurlException("HTTP $response->code: " . $response->error);
            }
        }
    }