<?php
function connect(){
try{
    return new mysqli("localhost","root","","wishlist");
  }catch(Exception $e){
    $error = "Connectie Gaat Niet Goed"; 
  }
}
  ?>