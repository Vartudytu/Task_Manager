  var loadFile = function(event) {
    var outputimage = document.getElementById('outputimage');
    outputimage.src = URL.createObjectURL(event.target.files[0]);
  };