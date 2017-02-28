<?php include __DIR__ . '/header.php'; ?>

<fieldset>
    <legend>Your entry</legend>
    
<?php if (isset($justCreated)) : ?>
    <p>
        Your entry has been created and can be retrieved
        <?php if ($entry->once) : ?>exactly <b>one</b> time <?php endif; ?>
        via the following link:
        <input type="text" readonly="readonly" style="width:100%" id="entryURL" value="<?=htmlspecialchars($GLOBALS['configuration']['publicPath'] . $GLOBALS['configuration']['publicSubdir'] . $id)?>">
        <script type="text/javascript">document.getElementById('entryURL').focus();</script>
    </p>
<?php endif; ?>

    <input type="hidden" id="encrypted" value="<?=htmlspecialchars($entry->encrypted)?>">
<?php if (empty($entry->value)) : ?>
    <p><textarea readonly="readonly" id="entry">This entry is encrypted. The provided key is invalid or you have JavaScript disabled.</textarea></p>
<?php else : ?>
    <p><textarea readonly="readonly" id="entry"><?=htmlspecialchars($entry->value)?></textarea></p>
<?php endif; ?>
</fieldset>
    
<?php include __DIR__ . '/footer.php'; ?>
