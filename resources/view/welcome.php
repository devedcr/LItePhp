welcomes <?= $name ?> <?= $email ?>
<?php foreach (["test1", "test2", "tes 3"] as $message) : ?>
    <h2><?= $message ?></h2>
<?php endforeach; ?>

<div>
    <?php if (isGuest()) : ?>
        <pre>
            <?= auth()->name ?>
            <a href="/auth/logout">logout</a>
        </pre>
    <?php else : ?>
        <p>No Auth</p>
    <?php endif; ?>
</div>