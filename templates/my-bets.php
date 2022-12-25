<main>
  <nav class="nav">
    <ul class="nav__list container">
      <?php foreach ($categories as $category): ?>
        <li class="promo__item promo__item--<?= $category['character_code']; ?>">
          <a class="promo__link" href="pages/all-lots.html"><?= $category['name_category'] ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <section class="rates container">
    <h2>Мои ставки</h2>
    <?php if (!empty($bets)): ?>
      <table class="rates__list">
      <?php foreach ($bets as $bet): ?>
        <tr class="rates__item">
        <td class="rates__info">
          <div class="rates__img">
            <img src="../uploads/<?= $bet["image"] ?>" width="54" height="40" alt="<?= $bet["lot_name"]; ?>">
          </div>
          <h3 class="rates__title"><a href="lot.php?id=<?= $bet["id"]; ?>"><?= $bet["lot_name"]; ?></a></h3>
        </td>
        <td class="rates__category">
          <?= $bet["name_category"]; ?>
        </td>
        <td class="rates__timer">
          <?php $time = get_time_left($bet["data_finish"]) ?>
          <div class="timer <?php if ($time[0] < 1 && $time[0] != 0): ?>timer--finishing <?php elseif($time[0] == 0): ?>timer--end<?php endif; ?>">
            <?= "$time[0] : $time[1]";?>
          </div>
        </td>
        <td class="rates__price">
          <?= get_formatted_price($bet["price_bet"]); ?>
        </td>
        <td class="rates__time">
          <?= $bet["data_finish"]; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
    <?php endif; ?>
  </section>
</main>
