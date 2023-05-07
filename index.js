//Page 1//
//Pictures function//
$("#pic-sec-two").hide();

$(".pic-sec-one").mouseover(function () {
  $("#pic-sec-two").slideDown(2100);
  $(".pic-sec-one").hide(2100);
});

//Brands function//
$(".brand-sec-two").hide();

$(".brand-sec-one").mouseover(function () {
  $(".brand-sec-two").slideDown(2100);
  $(".brand-sec-one").hide(2100);
});

//Page 2//
//Company overview function//
$(".story").hide();

$(".p2-image").mouseover(function () {
  $(".p2-row").fadeOut(2100);
  $(".story").slideDown(2100);
});

//Icon sound effect function//
$(".fa-arrow").mouseover(function () {
  var tom1 = new Audio("assets/sounds/tom-1.mp3");
  tom1.play();
});

$(".fa-crosshairs").mouseover(function () {
  var tom2 = new Audio("assets/sounds/tom-2.mp3");
  tom2.play();
});

$(".fa-heart").mouseover(function () {
  var tom3 = new Audio("assets/sounds/tom-3.mp3");
  tom3.play();
});

//Page 3//
//Shopping cart button function//
$("#modal-btn-1").hide();

$(".cart-btn").click(function () {
  $("#modal-btn-1").show(1200);
  window.scrollTo(0, 0);
});

//Shopping cart function//
$(document).ready(function () {
  update_amounts();
  $('.qty, .price').on('keyup keypress blur change', function () {
    update_amounts();
  });
});

function update_amounts() {
  var sum = 0.0;
  $('#myTable > tbody  > tr').each(function () {
    var qty = $(this).find('.qty').val();
    var price = $(this).find('.price').val();
    var amount = (qty * price);
    sum += amount;
    $(this).find('.amount').text('' + amount);
  });
  $('.total').text(sum);
}

//Quantity plus minus function//
var incrementQty;
var decrementQty;
var plusBtn = $(".cart-qty-plus");
var minusBtn = $(".cart-qty-minus");
var incrementQty = plusBtn.click(function () {
  var qtynum = $(this)
    .parent(".button-container")
    .find(".qty");
  qtynum.val(Number(qtynum.val()) + 1);
  update_amounts();
});

var decrementQty = minusBtn.click(function () {
  var qtynum = $(this)
    .parent(".button-container")
    .find(".qty");
  var QtyVal = Number(qtynum.val());
  if (QtyVal > 0) {
    qtynum.val(QtyVal - 1);
  }
  update_amounts();
});

//Clear cart function//
$("#clear-btn").click(function () {
  $('#myTable > tbody  > tr').each(function () {
    zeroQty = $(this).find('.qty').val('0');
    zeroAmount = $('.amount').text('0');
    zeroTotal = $('.total').text('0');
  });
});

//Payment link//
$(".payment-link").click(function () {
  window.location.href = 'https://www.paypal.com/sg/home';
  return false;
});

//Page 4//
//Questionnaire modal function//
$(".hidden-q1").hide();

$(".yes1").click(function () {
  $(".hidden-q1").slideDown(1200);
});

$(".hidden-q2").hide();

$(".yes3").click(function () {
  $(".hidden-q2").slideDown(1200);
});

//Text animation function//
var textWrapper = document.querySelector('.ml11 .letters');
textWrapper.innerHTML = textWrapper.textContent.replace(/([^\x00-\x80]|\w)/g, 
"<span class='letter'>$&</span>");

anime.timeline({loop: true})
.add({
    targets: '.ml11 .line',
    scaleY: [0,1],
    opacity: [0.5,1],
    easing: "easeOutExpo",
    duration: 720
})
.add({
    targets: '.ml11 .line',
    translateX: [0, document.querySelector('.ml11 .letters').getBoundingClientRect().width + 10],
    easing: "easeOutExpo",
    duration: 720,
    delay: 120
}).add({
    targets: '.ml11 .letter',
    opacity: [0,1],
    easing: "easeOutExpo",
    duration: 600,
    offset: '-=775',
    delay: (el, i) => 34 * (i+1)
}).add({
    targets: '.ml11',
    opacity: 0,
    duration: 1200,
    easing: "easeOutExpo",
    delay: 1200
});
