<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="confirmPage">
    <?= $this->Form->create() ?>
    <div class="confirmPage_wrap">
        <fieldset>
            <legend><?= __('入力内容の確認') ?></legend>
            <div class="confirm_wrap">
                <span class="confirm_head"><?= __('ユーザID') ?></span>
                <span class="confirm_des"><?= $user['username'] ?></span>
            </div>
            <div class="confirm_wrap">
                <span class="confirm_head"><?= __('パスワード') ?></span>
                <span class="confirm_des"><?= $user['password'] ?></span>
            </div>
        </fieldset>
		<div>
			<a href="<?= $this->Url->build(['action' => 'add']) ?>" style="display: block; background-color: black;">戻る</a>
			<?= $this->Form->button(__('この情報でユーザー登録する'), ['class' => 'confirm_btn pull-right']) ?>
		</div>
    </div>
    <?= $this->Form->end() ?>
</div>
