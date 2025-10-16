<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dynamic Div Position</title>
<style>
  .parent {
    position: relative;
    width:50%;
    height: 50vh;
    border: 1px solid black;
  }
  .child {
    position: absolute;
    width: 50px;
    height: 50px;
    background-color: red;
  }
  
.headertop-style{
  padding:10px;
  margin:40px;
  border: 2px solid red;
  cursor: pointer;
}
.parent{
  margin-top:0px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display:flex;
  justify-content:center
}
.fffchild{

}
</style>
</head>
<body>

<div style="display:flex;">
<div>
      <div class="headertop-style" id="heading">Heading</div>
      <div class="headertop-style" id="name">Name</div>
      <div class="headertop-style" id="amount">Amount</div>
      <div class="headertop-style" id="signature">Signature</div>
 
</div>
  <div>
          <button id="plusBtnY">Down</button>
        <button id="minusBtnY">Up</button>
        <button id="plusBtnX">Right</button>
        <button id="minusBtnX">Left</button>
  </div>

</div>


<div class="parent">
  <div id="fffchild" class="child"></div>
</div>

<script>
  const childDiv = document.querySelector('.child');
  const plusBtnY = document.getElementById('plusBtnY');
  const minusBtnY = document.getElementById('minusBtnY');
  const plusBtnX = document.getElementById('plusBtnX');
  const minusBtnX = document.getElementById('minusBtnX');

  plusBtnY.addEventListener('click', () => {
    const fffchild = document.getElementById("fffchild");
    const currentTop = parseInt(fffchild.style.top || 0); // Get the current top position
    fffchild.style.top = (currentTop + 2) + 'px'; // Increase top position by 2 pixels
  });

  minusBtnY.addEventListener('click', () => {
    const fffchild = document.getElementById("fffchild");
    const currentTop = parseInt(fffchild.style.top || 0); // Get the current top position
    fffchild.style.top = (currentTop - 2) + 'px'; // Decrease top position by 2 pixels
  });

  plusBtnX.addEventListener('click', () => {
    const fffchild = document.getElementById("fffchild");
    const currentLeft = parseInt(fffchild.style.left || 0); // Get the current left position
    fffchild.style.left = (currentLeft + 2) + 'px'; // Increase left position by 2 pixels
  });

  minusBtnX.addEventListener('click', () => {
    const fffchild = document.getElementById("fffchild");
    const currentLeft = parseInt(fffchild.style.left || 0); // Get the current left position
    fffchild.style.left = (currentLeft - 2) + 'px'; // Decrease left position by 2 pixels
  });
</script>

</body>
</html>
