var url_string = window.location.href;
var url = new URL(url_string);
var pname=url.searchParams.get("productName");
var description=url.searchParams.get("productDesc");
var price=url.searchParams.get("price");
document.getElementById("productName").innerHTML=pname;
document.getElementById("productDesc").innerHTML=description;
document.getElementById("price").innerHTML="$"+price;
document.getElementById("totalPrice").innerHTML="$"+price;
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'
  
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')
  
  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
  .forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      
      form.classList.add('was-validated')
    }, false)
  })
})()
const payClick=()=>{
  var email = document.getElementById('email').value;
  var sendParams=JSON.stringify({name:pname,price,email});
  console.log(sendParams)
  if(email!=''){
    fetch('mp/mp.php',{
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      method:'POST',
      body: sendParams
    }).then(res=>res.json()
    ).then(json=>{
      console.log(json);
      location.replace(json.init_point)
    })
  }
  
}
