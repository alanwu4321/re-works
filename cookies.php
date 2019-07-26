<?php
function checkCookies(){
if (isset($_COOKIE["curUser"])) {
    $curUser = explode(',', $_COOKIE["curUser"]);
    return $curUser;
} else {
    echo '<script type="text/javascript">',
        'expireMsg();',
        '</script>';
    }
}

function resetCookies(){
    if (isset($_COOKIE["curUser"])) {
        echo '<script type="text/javascript">',
            'logoutMsg();',
            '</script>';
    }
}
    
?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>;
<script type="text/javascript">
    function expireMsg() {
        Swal.fire({
            type: 'warning',
            title: 'Session Expired',
            text: "Please login again",
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
            window.location.href = "/login.php";
        })
    }
    function logoutMsg() {
        Swal.fire({
            type: 'success',
            title: 'Logout Succesfully',
            text: "See you again!",
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
            document.cookie = "curUser= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
        })
    }
</script>