<?php
session_start();
include ('includes/config.php');
include ('booknow.php');


if (!empty($_POST['vehicleid'])) {
    $id = intval($_POST['vehicleid']);
    $email = $_SESSION['login'];
    $ret = "SELECT * FROM tblBooking WHERE vehicleId = $id";
    $query = $dbh->prepare($ret);
    $query->execute();
    $results = $query -> fetchAll(PDO::FETCH_ASSOC);
    $to_encode = json_encode($results);
    ?>
    <div class="input-group input-daterange" style="margin-top: 24px;">
        <input id="startDate" name="startDate" type="text" class="form-control" readonly="readonly">
        <span class="input-group-addon">to</span>
        <input id="endDate" name="endDate" type="text" class="form-control" readonly="readonly">
    </div>
    <?php
}
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script>
    var disableDates = [];
    var data = JSON.parse( '<?php echo $to_encode; ?>' );
    // console.log( data[0].email );
    // console.log(data.length);
    var len;
    for (var i = 0, len = data.length; i < len; i++) {
        var from1 = data[i].fromDate;
        var to1 = data[i].toDate;
        var from = new Date(from1);
        from.setDate(from.getDate() + 1);
        var to = new Date(to1);
        to.setDate(to.getDate() + 1);
        while (from <= to) {
            disableDates.push(new Date(from));
            from = moment(from).add(1, 'days').toDate();
        }
    }
    // console.log(disableDates);
    // console.log('<?php echo $to_encode; ?>');
    // console.log('<?php echo $id; ?>');
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.input-daterange').datepicker({
            datesDisabled: disableDates,
        });
        $('#startDate').click(function() {
            $(this).datepicker('hide');
            $('#endDate').focus()
        });
    });
</script>