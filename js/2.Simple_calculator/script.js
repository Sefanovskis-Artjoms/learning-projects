const display = {
  element:document.querySelector('.display'),
  initPresent: true,
}

// getting all buttons in array
const button = document.querySelectorAll(".btn")

// adding event listener on all buttons 
button.forEach(button => {
  // Defining different response for different button types 
  button.addEventListener("click", function() {
    switch (button.name) {
      case "operator":
        // getting last character of an expression
        const lastChar = display.element.textContent[display.element.textContent.length - 1]
        const operators = ['+','-','*','/','.'] 
        if (!display.initPresent) {
          // If last character is operator then it is replaced with current operator
          if(operators.includes(lastChar)){
            display.element.textContent = display.element.textContent.substring(0,display.element.textContent.length - 1)+button.value

          }//else it is appended
          else{
            display.element.textContent+=button.value
          }
        }
        break;
      case "num":
        if (!display.initPresent) {
          display.element.textContent+=button.value
        }
        else{
          display.initPresent=false
          display.element.textContent=button.value
        }
        break;
      case "clear":
        if (!display.initPresent) {
          display.element.textContent = "Start writing something"
          display.initPresent = true
        }
        break;
      case "delete":
        if (!display.initPresent) {
          display.element.textContent = display.element.textContent.substring(0,display.element.textContent.length - 1)
        }
        break;
      case "equals":
        if (!display.initPresent) {
          if (!display.initPresent) display.element.textContent = eval(display.element.textContent) 
        }
        break;
    }
  })
});