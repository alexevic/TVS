function doValidate()
{
  console.log('Validuojama...');
  try
  {
    em = document.getElementById('em').value;
    pw = document.getElementById('psw').value;
    console.log("Validuoja paštą = " + em + "; slaptažodį = " + pw);
    if ((pw == null || pw == "") || (em == null || em == ""))
    {
      alert("Abu laukai turi būti užpildyti!");
      return false;
    }
    return true;
  }
  catch(e)
  {
    return false;
  }
  return false;
}
