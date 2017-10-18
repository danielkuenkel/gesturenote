<?php
header('Content-Type: application/json');
header("Expires: Tue, 01 Jan 1990 00:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$error = "false";
$tz = $_GET['tz'];

if (!in_array($tz, DateTimeZone::listIdentifiers())) {
    $error = 'invalid time zone';
    $tz = 'UTC';
}

date_default_timezone_set($tz);
?>
<?php echo htmlspecialchars($_GET['callback'], ENT_QUOTES, 'UTF-8'); ?>({
"tz": "<?php echo $tz ?>",
"hour": <?php echo date('G'); ?>,
"datetime": "<?php echo date(DATE_RFC2822); ?>",
"second": <?php echo intval(date('s')); ?>,
"error": "<?php echo $error; ?>",
"minute": <?php echo intval(date('i')); ?>,
"millisecond": <?php echo intval(date('u')); ?>
})