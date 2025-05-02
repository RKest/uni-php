<div style="position: absolute; margin: 20; right: 0;">
	<form action="/tasks/z11/api/add_animation.php" method="post">
		<div>
			<label for="x0">x0</label>
			<input name="x0" type="number"/>
		</div>

		<div>
			<label for="y0">y0</label>
			<input name="y0" type="number" />
		</div>

		<div>
			<label for="x_delta">x_delta</label>
			<input name="x_delta" type="number" />
		</div>

		<div>
			<label for="y_delta">y_delta</label>
			<input name="y_delta" type="number" />
		</div>

		<div>
			<label for="begin_s">begin_s</label>
			<input name="begin_s" type="number" />
		</div>

		<div>
			<label for="diameter">diameter</label>
			<input name="diameter" type="number" />
		</div>

		<div>
			<label for="time_s">time_s</label>
			<input name="time_s" type="number"/>
		</div>

		<div>
			<label for="color">color</label>
			<input name="color" />
		</div>
		<div>
			<button type="submit">Add</button>
		</div>
	</form>
</div>
<div hx-get="/tasks/z11/api/animations.php" hx-trigger="load">
</div>
