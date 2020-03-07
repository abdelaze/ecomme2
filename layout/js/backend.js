/////////////////////////////////////////

// trigger select box


  $("select").selectBoxIt({

     theme: "jqueryui",
     
     showEffect: "shake",

    // Sets the animation speed to 'slow'
    showEffectSpeed: 'slow',

    // Sets jQueryUI options to shake 1 time when opening the drop down
    showEffectOptions: { times: 1 },

    // Uses the jQueryUI 'explode' effect when closing the drop down
    hideEffect: "explode"

  






  });

  ///////////////////


   // toggle between login and signup



 var login = document.getElementById('login');
 var signup = document.getElementById('signup');



 login.onclick = function () {

    document.forms[0].style.display = 'block';
    document.forms[1].style.display = 'none';
    if(!login.classList.contains('selected')) {

       login.classList.add('selected');
        signup.style.color='#867b7b';

  }
 

 }


 signup.onclick = function () {

    document.forms[0].style.display = 'none';
    document.forms[1].style.display = 'block';
    login.classList.remove('selected');
    signup.style.color='#5cb85c';

 }
   



  ////////////////////////////////


  // put data in item when adding it

var inpt1 = document.getElementById('live-name');
var inpt2 = document.getElementById('live-desc');
var inpt3 = document.getElementById('live-price');
var live = document.getElementsByClassName('live-preview');



inpt1.onkeyup = function (){

    live[0].children[2].children[0].textContent = inpt1.value; 
}


inpt2.onkeyup = function (){

    live[0].children[2].children[1].textContent = inpt2.value; 
}


inpt3.onkeyup = function (){

    live[0].children[0].textContent = "$"+inpt3.value; 
}


/////////////////////////////////////////////////










// Make confirm message 




var conf = document.getElementsByClassName('confirm');


/*conf.onclick = function() {

  return confirm("are you sure ? ");
}*/

for(var i = 0 ;i<conf.length;i++ ) {

if(conf[i]){

conf[i].onclick = function() {


  return confirm("are you sure ? ");

  }

}

}



//////////////////////////////////////////////////////////////////////////



var input = document.getElementsByClassName('form-control');

//alert(input.length);
//input[0].value="*";

// Add  red star required elements

for(var i=0;i<input.length;i++) {


    if(input[i].hasAttribute('required')) {

    
    var elem = document.createElement("span");
    
    elem.classList.add('star');

     var text = document.createTextNode("*");

     elem.appendChild(text);



     input[i].after(elem);

   }
    else {

    	continue;
    }


}

///////////////////////////////////////////////////









  