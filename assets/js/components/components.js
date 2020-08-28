class Components {

    table = function (data){
        thead = `
        <div class="card">
            <div class="card-header">
                <h4 id="table-title">table title</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-event">
                        <thead>
                            <tr>
                            ${Object.keys(data).map(function (key) {
                                return "<th>"+obj[key]+"</th>"           
                            }).join("")}
                            </tr>
                        </thead>
                        <tbody id="table-event-body">
                            ${Object.keys(data).map(function (val) {
                                return "<tr><td>"+val+"</td></tr>"           
                            }).join("")}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        `;
        return t;
    };

}