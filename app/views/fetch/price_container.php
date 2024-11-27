<div class="other-info-card__price price-other-info-card" id = "card-other-price">
    <p class="price-other-info-card__total">Итого 
        <strong>
            <?php echo htmlspecialchars($count_item * $actual_price) ?>mdl
        </strong> <span>(без TVA)</span>
    </p>
    <p class="price-other-info-card__discount">Вы сэкономили 
        <strong>
            <?php echo htmlspecialchars($count_item * $item->price - $count_item * $actual_price_options_of)?>mdl
        </strong>
    </p>
</div>