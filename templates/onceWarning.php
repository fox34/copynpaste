<?php include __DIR__ . '/header.php'; ?>

<fieldset>
    <legend>Show entry</legend>
    <p><b>Warning:</b> This entry can only be viewed once.</p>
    
<?php if (empty($entry->value)) : ?>
    <p class="noJS">This entry is encrypted. You need to enable JavaScript to show this entry.</p>
    <p class="jsOnly">
        <a href="<?=htmlspecialchars($query['fileID'])?>?showOnce=true" id="onceLink">
            View entry
        </a>
    </p>
<?php else : ?>
    <p>
        <a href="<?=htmlspecialchars($query['fileID'])?>?showOnce=true" id="onceLink">
            View entry
        </a>
    </p>
<?php endif; ?>
</fieldset>

<?php include __DIR__ . '/footer.php'; ?>
