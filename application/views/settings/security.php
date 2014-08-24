<p>Here are the 50 latest events on your account.</p>

<table class="table table-bordered">
  <tr>
    <th>Event</th>
    <th>Time</th>
    <th>IP address</th>
  </tr>

  <? foreach($events as $event): ?>
  <tr>
    <td>
      <?=$event['object'].'.'.$event['event']?>
      <? if($event['value']): ?>
      <br /><small>(<?=$event['value']?>)</small>
      <? endif; ?>
    </td>
    <td><?=date('Y-m-d g:i A', $event['time'])?> (Eastern)</td>
    <td>
      <?=inet_ntop($event['ip'])?>
      <? if(inet_ntop($event['ip'])==$_SERVER['REMOTE_ADDR']):?>
      <small>(you)</small>
      <? endif; ?>
    </td>
  </tr>
  <? endforeach; ?>
</table>