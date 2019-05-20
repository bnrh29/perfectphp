<div class="status">
    <div class="status_content">
        <a href="<?= $base_url; ?>/user/<?= $this->escape($status['user_name']); ?>">
            <?php echo $this->escape($status['user_name']); ?>
        </a>
        <?php echo $this->escape($status['body']); ?>
    </div>
    <div>
        <a href="<?= $base_url ?>/user/<?= $this->escape($status['user_name']); ?>/status/<?= $this->escape($status['id']); ?>">
            <?php echo $this->escape($status['created_at']); ?>
        </a>
    </div>
</div>