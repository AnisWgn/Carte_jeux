// Define the allowed key codes
var allowedKeys = {
    37: 'left',
    38: 'up',
    39: 'right',
    40: 'down',
    65: 'a',
    66: 'b'
  };
  
  // Define the Konami Code sequence
  var konamiCode = ['up', 'up', 'down', 'down', 'left', 'right', 'left', 'right', 'b', 'a'];
  
  // Track the user's progress in entering the sequence
  var konamiCodePosition = 0;
  
  // Listen for keydown events
  document.addEventListener('keydown', function(e) {
    var key = allowedKeys[e.keyCode];
    var requiredKey = konamiCode[konamiCodePosition];
  
    // Check if the key pressed matches the next key in the Konami sequence
    if (key === requiredKey) {
      konamiCodePosition++;
  
      // If the entire sequence was entered correctly
      if (konamiCodePosition === konamiCode.length) {
        activateCheats();
        konamiCodePosition = 0;
      }
    } else {
      // Reset if the wrong key was pressed
      konamiCodePosition = 0;
    }
  });
  
  // Function to run when the Konami Code is successfully entered
  function activateCheats() {
    alert("Konami Code Activated!");
    // Add any desired functionality here, such as changing the page or playing a sound
  }
  