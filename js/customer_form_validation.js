/*

customer_feedback.html

*/

function validateFeedback() {

   // Get the selected rating
  var rating = document.querySelector("input[name='rating']:checked").value;


   // Get the entered comments
   var comments = document.getElementById("textAreaDescribe").value;
   

  if(comments == ""){
    alert("Please describe your experience.");
      return false;
  } else{return true;}
}

/*

customer_make_payment.php

*/

  function validatePayment() {

    // Get the selected shipping address option.
    var shippingOption = document.querySelector('input[name="addressOption"]:checked').value;

    if(shippingOption == "alternateAddress"){

      // get the value of alternate address text area.
      var address = document.getElementById("alternateAddressText").value;

      if(address == ""){
        alert("Please enter the alternate address.");
        return false;
      }

    }

     // Validate if the customer has uploaded the receipt file or not.
    else if (document.getElementById("receiptFile").value == "") {
      alert("Please upload your receipt file.");
      return false;
    } 

    else{return true;}
    
  }

/*

customer_registration.html

*/


function validateRegistration(){

  var name = document.getElementById("name").value;
  var email = document.getElementById("email").value; 
  var username = document.getElementById("username").value;
  var address = document.getElementById("address").value;
  var phone = document.getElementById("phone").value;
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("confirm-password").value;
  var pattern = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~\d]+/;

  // check if name contains a number or special character.
  if(pattern.test(name) == true){
    alert("Name cannot have a number or special character.");
      return false;

  }

  // check if email is empty.
  else if(email == ""){
    alert("Please enter your email.");
      return false;

  }

  // check if username less than 5 characters.
  else if(username.length < 5){
    alert("Username must be at least 5 characters.");
      return false;

  }

  // check if address is empty.
  else if(address == ""){
    alert("Please enter your address.");
      return false;

  }

  // check if phone number is 10 digit.
  else if(phone.length != 10){
    alert("Phone number must be 10 digits.");
      return false;

  }

  // check if password is at least 5 characters.
  else if(password.length < 5){
    alert("Password must be at least 5 characters.");
      return false;

  }

  // check if password match with the confirm password
  else if(password != confirmPassword){
    alert("Confirm password does not match with password.");
      return false;

  }

  else {
    return true;
  }

}

/*

customer_request_form.php

*/

function validateRequestForm(){

  var file = document.getElementById("uploadImage").value;
  var description = document.getElementById("description").value;
  selectType = document.querySelector('#selectType');
  outputType = selectType.value;
  selectBrand = document.querySelector('#selectBrand');
  outputBrand = selectBrand.value;

  // check if customer has not selected the appliance type.
  if(outputType == "select_type"){
    alert("Please select appliance type.");
    return false;
  }

  // check if customer has not selected appliance brand.
  else if(outputBrand == "select_brand"){
    alert("Please select appliance brand.");
    return false;
  }

  // check if customer has not described the appliance problem.
  else if(description == ""){
    alert("Please describe the appliance problem.");
    return false;
  }

  // check if customer has not uploaded the applaince image.
  else if(file==""){
    alert("Please upload the image of the appliance.");
    return false;
  }

  // return true if all information required has been entered by the customer.
  else{
    return true;
  }
    
}