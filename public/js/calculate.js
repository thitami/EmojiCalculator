$('#submit-calc').on('submit', function (e) {
    alert('1111asdsad');
    e.preventDefault();
    var firstOperand = $('#firstOperand').val();
    var secondOperand = $('#secondOperand').val();
    var operation = $('#operation').val();
    console.log(firstOperand + secondOperand + operation);
    $.ajax({
        type: "POST",
        url: host + '/calculate',
        data: {first_operand: firstOperand, second_operand: secondOperand, operation: published_at},
        success: function( msg ) {
            console.log(msg)
        }
    });
});
