jQuery(function(){

  $('#progress').hide();
  $('#downloadBtn').hide();

  function resetCoords()
  {
      $('#x').val('');
      $('#y').val('');
      $('#w').val('');
      $('#h').val('');
  };

    $('#fileupload').fileupload({
        url: "upload",
        dataType: 'json',
        done: function (e, data) {
          $('#progress').hide();
          resetCoords();
          $.each(data.result.files, function (index, file) {
            console.log(file);
                        console.log(file.name);

                $('#files').html($('<img/>').attr('src',file));
                $('.jcrop-preview').attr('src',file);
                $('#previewModel').modal('show');
            });



            // Create variables (in this scope) to hold the API and image size
            var jcrop_api,
                boundx,
                boundy;
            
            $('#files img').Jcrop({
              minSize: [70,70],
              onChange: updateCoords,
              onSelect: updateCoords,
              aspectRatio: 1/1
            },function(){
              // Use the API to get the real image size
              var bounds = this.getBounds();
              boundx = bounds[0];
              boundy = bounds[1];
              // Store the API in the jcrop_api variable
              jcrop_api = this;

              // Move the preview into the jcrop container for css positioning
              //$preview.appendTo(jcrop_api.ui.holder);
            });

            function updateCoords(c)
            {
                $('#x').val(c.x);
                $('#y').val(c.y);
                $('#w').val(c.w);
                $('#h').val(c.h);
            };
        },
        fail: function(){
          alert('Error uploading an image');
        },
        always: function(e,data){
          $('#progress').hide();
        },
        start: function(e,data){
          $('#progress').show();
        },
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, 
        maxNumberOfFiles: 1,
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        }
    });

    // create spinner 
    var opts = {
      lines: 13, // The number of lines to draw
      length: 20, // The length of each line
      width: 2, // The line thickness
      radius: 12, // The radius of the inner circle
      corners: 1, // Corner roundness (0..1)
      rotate: 0, // The rotation offset
      direction: 1, // 1: clockwise, -1: counterclockwise
      color: '#CCC', // #rgb or #rrggbb
      speed: 1, // Rounds per second
      trail: 67, // Afterglow percentage
      shadow: true, // Whether to render a shadow
      hwaccel: false, // Whether to use hardware acceleration
      className: 'spinner', // The CSS class to assign to the spinner
      zIndex: 2e9
    };

    ImageSpinner = new Spinner(opts).spin(document.getElementById('previewSpinner'));
    ImageSpinner.stop();

    $('#updatepicform').submit(function() {
      ImageSpinner.spin(document.getElementById('previewSpinner'));
      $.post("previewpic", $("#updatepicform").serialize())
          .done(function(data) { location.reload();
 })
          .fail(function() { alert("error"); })
          .always(function() { ImageSpinner.stop();});
      return false;
    });
});