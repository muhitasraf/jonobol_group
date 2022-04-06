$(function () {
  //Initialize Select2 Elements
  $('.select2').select2({});

  // image file upload preview
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        // Use the input element's name attribute to select and
        // update the image element with matching id
        $('#' + input.name).attr('src', reader.result); //e.target.result
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("input[type=file]").change(function() {
    readURL(this);
    //filename = this.files[0].name
    //console.log(filename);
  });

  //datetime picker
  $('.form_datetime').datetimepicker({
    weekStart: 1,
    fontAwesome: true,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 'month',
    minuteStep: 10,
    forceParse: 0,
    showMeridian: 1,
    pickerPosition: "bottom-right",
    //startDate: new Date()
  });

  //date picker
  $('.form_date').datetimepicker({
    fontAwesome: true,
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0,
    pickerPosition: "bottom-right",
    format:'dd-mm-yyyy'
  });

  //time picker
  $('.form_time').datetimepicker({
    fontAwesome: true,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minuteStep: 10,
    forceParse: 0,
    showMeridian: 1,
    pickerPosition: "bottom-right",
    format: "HH:ii P"
  });

  //time picker
  $('.form_month').datetimepicker({
    fontAwesome: true,
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 3,
    minView: 3,
    forceParse: 0,
    pickerPosition: "bottom-right",
    format:'MM'
  });

  //time picker
  $('.form_year').datetimepicker({
    fontAwesome: true,
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 4,
    minView: 4,
    forceParse: 0,
    pickerPosition: "bottom-right",
    format:'yyyy'
  });

  $('.delete_btn').on('click',function () {
      var confirmation = confirm("Are you sure ?");
      if (confirmation){
        return true;
      }
      else
        return false;
  });

  //time picker
  /*$('.form_time').datetimepicker({
    fontAwesome: true,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minuteStep: 30,
    forceParse: 0,
    showMeridian: 1,
    pickerPosition: "bottom-right",
    format: "HH:ii P"
  });*/

  $('.btn-print').on('click',function () {
    removeDataTable();

    window.print();
  });

  $('.btn-print-landscape').on('click',function () {
    removeDataTable();

    printLandscape();

    window.print();
  });

  /** Set local storage if expaneded sidebar **/
  $('.navbar-nav:first-child').on('click', function(e){
    let is_body_collapse = $('body.sidebar-collapse').length;
    is_body_collapse = is_body_collapse === 1 ? "opened" : "collapsed";
    localStorage.setItem("nav_sidebar",is_body_collapse);
  });

  /** Retrieve local storage value and change class of body **/
  nav_sidebar_local_storage_value = localStorage.getItem("nav_sidebar");
  if(nav_sidebar_local_storage_value !== null) {
    if(nav_sidebar_local_storage_value === "collapsed") {
      $('body').removeClass('sidebar-open').addClass('sidebar-collapse');
    }
  }

});


function removeDataTable() {
  $('.table').removeClass('dataTable');
}

function printLandscape() {
  var css = '@page { size: landscape; }',
  head = document.head || document.getElementsByTagName('head')[0],
  style = document.createElement('style');

  style.type = 'text/css';
  style.media = 'print';

  if (style.styleSheet){
    style.styleSheet.cssText = css;
  } else {
    style.appendChild(document.createTextNode(css));
  }

  head.appendChild(style);
}

function RemoveHTMLTags(html) {
  var regX = /(<([^>]+)>)/ig;
  return html.replace(regX, '');
}