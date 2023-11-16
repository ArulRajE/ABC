<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.10.2/dist/parsley.min.js"></script>
  <title>Select2 with Parsley Validation</title>
</head>
<body>

  <form id="myForm">
    <label for="selected_come">Select an option:</label>
    <select class="form-select mainvaldata" required name="namefrom[]" id="selected_come" onchange="handleSelectChange(this, 1)"></select>

    <label for="action1">Select an action:</label>
    <select class="form-select actiondata" required onchange="handleSelectChange(this, 2)" name="action[]" id="action1"></select>

    <!-- Add more select boxes as needed -->

    <input type="submit" value="Submit">
  </form>

  <script>
    $(document).ready(function() {
      // Initialize Select2
      $('.form-select').select2();

      // Initialize Parsley
      $('#myForm').parsley();
    });

    function handleSelectChange(selectElement, fieldIndex) {
      // Reset Parsley error for the specific field when the select value changes
      $('#myForm').parsley().reset();
    }
  </script>

</body>
</html>
