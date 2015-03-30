<? /* for use with own icons. there is no mapping yet
  <img src="<?= $iconUrl.'sw-'.trim($data->weather[0]->icon, 'd').'.svg' ?>">
 */ ?>
<style>
    div.weather {
        text-align: center;
        padding: 4px;
        width: 100%;
    }
    div.weather p,div.weather h3 {
        margin: 0px;
    }
</style>
<div style="display: flex">
    <?= $this->render_partial('_weather.php', array('title' => _('Aktuell'), 'weather' => $data)); ?>
    <?= $this->render_partial('_weather.php', array('title' => _('Heute'), 'weather' => $forecast->list[0])); ?>
    <?= $this->render_partial('_weather.php', array('title' => _('Morgen'), 'weather' => $forecast->list[1])); ?>
    <?= $this->render_partial('_weather.php', array('title' => _('Übermorgen'), 'weather' => $forecast->list[2])); ?>
</div>