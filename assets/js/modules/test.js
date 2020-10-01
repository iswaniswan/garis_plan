export const myNumbers = [1, 2, 3, 4];
const animals = ['Panda', 'Bear', 'Eagle']; // Not available directly outside the module

export function myLogger() {
    console.log(myNumbers, animals);
}

export class Alligator {
    constructor() {
        console.log('alligator')
    }
}

var btnMerge = document.querySelectorAll('data-test="merge-button"')

var btnMergeClick = btnMerge.click(function(){ 
    setTimeout(()=>{
        var btnMergeConfirm = document.querySelectorAll('data-test="confirm-button"]');
        if(btnMergeConfirm){
            btnMergeConfirm.click()
        }
    }, 1000)
})

var myFunc = function(){
    console.log("test")
}

var btnMerge = document.querySelector('[data-test="merge-button"]');
btnMerge.click()
setTimeout(()=>{
    var btnConfirm = document.querySelector('[data-test="confirm-button"]');
    btnConfirm.click()
}, 3000)

var btnConfirm = document.querySelectorAll('[data-test="confirm-button"]');
setTimeout(()=>{
    var btnMerge = document.querySelectorAll('[data-test="merge-button"]');
    btnMerge.click()
}, 3000)

var btnMerges = document.querySelectorAll('[data-test="merge-button"]');
btnMerges.forEach(()=>{
    var btnMerge = document.querySelector('[data-test="merge-button"]');
    
    new Promise(
        function (resolve, reject) {
            if (btnMerge) {
                resolve(btnMerge.click()); 
            } else {
                var reason = new Error('some error');
                reject(reason); 
            }
        }
    );

})

for(i=0; i<4; i++){setImmediate(document.querySelector('.CloseButton-ab9wzy-0').click())}

for(i=0; i<100; i++){
    setImmediate(function(){
        document.querySelector('.CloseButton-ab9wzy-0').click()
    })
}

for(i=0; i<100; i++){
    setImmediate(function() {
        setImmediate(function() {
            var btnMerge = document.querySelector('[data-test="merge-button"]');
            btnMerge.click();
    });
    
    setImmediate(function() {
        var btnConfirm = document.querySelector('[data-test="confirm-button"]');
        btnConfirm.click();
    });
    
    });
}


for(i=0; i<10; i++){
    setImmediate(function() {
        setImmediate(function(){
            var btnClose = document.querySelector('.CloseButton-ab9wzy-0');
            if(btnClose) btnClose.click()
        })

        setImmediate(function() {
            var btnMerge = document.querySelector('[data-test="merge-button"]');
            if(btnMerge) btnMerge.click();
        });
    
        setImmediate(function() {
            var btnConfirm = document.querySelector('[data-test="confirm-button"]');
            if(btnConfirm) btnConfirm.click();
        });
    
    });
}


// close button only
for(i=0; i<100; i++){
    setImmediate(function(){
        var btnClose = document.querySelector('.CloseButton-ab9wzy-0');
        if(btnClose){
            setImmediate(function(){
                btnClose.click()
            })
        }
    })
}
