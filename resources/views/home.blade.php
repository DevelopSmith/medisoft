<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Poker Chance Calculator</title>

		<!-- Custom CSS -->
		<link href="/css/custom.css" rel="stylesheet" />

	</head>

	<body>
		<h2 class="title">Poker Chance Calculator</h2>

		@if(isset($suit) && isset($value))
			<h3 class="sub-title">
				Your selected card is <strong style="color:red;">{{$suit ?? ''}}{{$value ?? ''}}</strong>. Your chance is <strong style="color:red;">{{isset($chance) ? $chance . '%' : 'Unknown'}}</strong>
			</h3>
		@endif

		@if(!isset($suit) && !isset($value))
			<form id="form" class="flex-center" method="POST" action="/">
				{{ csrf_field() }}

				<label for="suit">Suit</label>
				<select name="suit" id="suit">
					<option value="">Select a Suit</option>
					<option value="S">Spades</option>
					<option value="D">Diamonds</option>
					<option value="C">Clubs</option>
					<option value="H">Hearts</option>
				</select>

				<label for="value">Value</label>
				<select name="value" id="value">
					<option value="">Select a Value</option>
					<option value="A">Ace</option>
					<option value="K">King</option>
					<option value="Q">Queen</option>
					<option value="J">Jack</option>
					<option value="10">10</option>
					<option value="9">9</option>
					<option value="8">8</option>
					<option value="7">7</option>
					<option value="6">6</option>
					<option value="5">5</option>
					<option value="4">4</option>
					<option value="3">3</option>
					<option value="2">2</option>
				</select>

				<button type="submit" id="select-card">Select</button>
			</form>
		@endif

		<?php
			$deck = isset($deck) ? explode(',', $deck) : [];
			$selected_cards_array = isset($selected_cards) && $selected_cards !== '' ?  explode(',', $selected_cards) : [];
		?>

		@if(isset($suit) && isset($value))
			<form id="remaining-cards" class="flex-center" method="POST" action="/">
				{{ csrf_field() }}

				<input type="hidden" name="suit" value="{{$suit}}" />
				<input type="hidden" name="value" value="{{$value}}" />
				<input type="hidden" name="selected_cards" value="{{$selected_cards}}" />

				<ul class="cards-list">
					@foreach($deck as $card)
						@if(!in_array($card, $selected_cards_array))
							<li class="card">
								<label for="card-{{$card}}">
									<input type="radio" name="selected_card" id="card-{{$card}}" value="{{$card}}" onchange="this.form.submit()" />
									<img src="{{asset('cards/red_back.png')}}" />
								</label>
							</li>
						@endif
					@endforeach
				</ul>
			</form>
		@endif

		@if(count($selected_cards_array) > 0)
			<h3 class="sub-title">Withdrawn Cards</h3>

			<ul class="cards-list">
				@foreach($selected_cards_array as $card)
					<li class="card">
						<img src="{{'cards/' . $card .'.png'}}" />
					</li>
				@endforeach
			</ul>
		@endif

		<script type="text/javascript">
			var suit = "<?php Print($suit ?? ''); ?>";
			var value = "<?php Print($value ?? ''); ?>";
			var selected_card = "<?php Print($selected_card ?? ''); ?>";
			var chance = "<?php Print($chance ?? ''); ?>";

			if(selected_card !== '' && suit + value === selected_card){
				alert('Got it, the chance was ' + (chance || 0)  + '%');
				window.location.replace('/');
			}
		</script>
	</body>
</html>
