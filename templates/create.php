<?php include __DIR__ . '/header.php'; ?>

<fieldset>
    <legend>Create new entry</legend>
    <form action="?action=create" method="POST" id="createForm">
        <input type="hidden" name="encrypted" id="encrypted">
        <p><textarea name="value" id="value" wrap="off"></textarea></p>
        <p><b>Valid access times (including borders; use : for time spans; leave empty for no restriction):</b></p>
        <p>
            <input type="text" name="year" placeholder="Year" style="width:70px">
            <input type="text" name="month" placeholder="Month (1-12)" style="width:70px">
            <input type="text" name="week" placeholder="Week (1-53)" style="width:70px">
            <input type="text" name="dayOfWeek" placeholder="Day of week (1 = Monday)" style="width:150px">
            <input type="text" name="dayOfMonth" placeholder="Day of month" style="width:75px">
            <input type="text" name="hour" placeholder="Hour (0-23)" style="width:70px">
            <input type="text" name="minute" placeholder="Minute (0-59)" style="width:75px">
        </p>
        <p>
            <label>
                <input type="checkbox" name="once" value="1"> Allow access only once
            </label><br>
            <!--
            <label>
                <input type="checkbox" name="editable" value="1"> Allow editing (not available for "once")
            </label><br> -->
            <label>
                <input type="checkbox" id="encrypt" name="encrypt" value="1" disabled="disabled"> Encrypt contents (JavaScript required)
                <span id="encryptStatus"><b>Not ready yet. Please enable JS and move your mouse to generate some randomness.</b></span>
            </label>
        </p>
        <p><input type="submit" id="submit" value="Create"></p>
    </form>
</fieldset>

<?php include __DIR__ . '/footer.php'; ?>
