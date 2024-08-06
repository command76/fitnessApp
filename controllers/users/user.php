<?php
// for executing user based functions
namespace controllers;
class user
{
  public function isEnabled()
  {
    return true
  }
  public function test($test)
  {
    echo "testing";
    echo $test;
  }
}
?>
