<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Shift</title>
</head>
<body>
    <h1>Shift Management</h1>
    <button id="activateShiftButton">Activate Shift</button>

    <script>
        document.getElementById('activateShiftButton').addEventListener('click', function() {
            fetch('activate_shift.php', {
                method: 'POST'
            })
            .then(response => response.text())
            .then(data => {
                if(data==1){
                    window.location.href = "/client";
                }else{
                    alert("Failed to Activate Shift");
                }
                
                // alert(data);
                // // if(data==="success"){
                // //     window.location.href = "/client";
                // // }
                
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
