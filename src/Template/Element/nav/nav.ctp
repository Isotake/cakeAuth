<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Guest') ?></li>
        <li><?= $this->Html->link(__('Signup'), ['action' => 'signup']) ?></li>
        <li><?= $this->Html->link(__('Login'), ['action' => 'login']) ?></li>
        <li class="heading"><?= __('User') ?></li>
        <li><?= $this->Html->link(__('Profile'), ['action' => 'view']) ?></li>
        <li><?= $this->Html->link(__('Edit Profile'), ['action' => 'edit']) ?></li>
        <li><?= $this->Html->link(__('Logout'), ['action' => 'logout']) ?></li>
        <li><?= $this->Html->link(__('Delete'), ['action' => 'delete']) ?></li>
<!--        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li> -->
        <li class="heading"><?= __('Admin') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
    </ul>
</nav> 