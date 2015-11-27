<div class="weather">
    <h3><?= htmlReady($title) ?></h3>
    <img src="https://openweathermap.org/img/w/<?= htmlReady($weather->weather[0]->icon) ?>.png">
    <p><?= round(($weather->main ? $weather->main->temp : $weather->temp->day) - 273.15) ?>°</p>
    <p><?= htmlReady(_($weather->weather[0]->description)) ?></p>
</div>