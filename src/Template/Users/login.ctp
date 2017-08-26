<?= $this->element('nav/nav'); ?>
<div class="users index large-9 medium-8 columns content">
    <div class="users form">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Please enter your username and password') ?></legend>
            <?= $this->Form->control('username') ?>
            <?= $this->Form->control('password') ?>
	    <?= $this->Form->control('autologin', ['type' => 'checkbox', 'default' => true, 'label' => '保存する']) ?>
        </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
    </div>
</div>
