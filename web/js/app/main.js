$(document).ready(function() {
    $('.delete-form').submit(function() {
        var response = confirm("Are you sure you wish the delete this item?");
        return response; //you can just return c because it will be true or false
    });
});