				<div class="registration-form">
					<?php echo validation_errors(); ?>
					<?php echo form_open('registration/create'); ?>
						<div class="row">
							<div class="col-lg-12">
								<h2 class="center">Registration Information</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<label>Registrant's name (to appear on badge):</label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<div class="row">
									<label for="first_name" class="col-lg-3 col-form-label">First Name:</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" id="first_name" name="first_name" />
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<label for="last_name" class="col-lg-3 col-form-label">Last Name:</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" id="last_name" name="last_name" />
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-lg-12">
								<label>Registrant's spouse or guest name (to appear on badge):</label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<div class="row">
									<label for="guest_first" class="col-lg-3 col-form-label">First Name:</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" id="guest_first" name="guest_first" />
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<label for="guest_last" class="col-lg-3 col-form-label">Last Name:</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" id="guest_last" name="guest_last" />
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="form-group row">
							<div class="col-lg-6">
								<div class="row">
									<label for="total_number" class="col-lg-7 col-form-label">Total number in registrant's party:</label>
									<div class="col-lg-5">
										<input class="form-control" type="text" id="total_number" name="total_number" />
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<label for="council_number" class="col-lg-3 col-form-label">Council #:</label>
									<div class="col-lg-3">
										<input class="form-control" type="text" id="council_number" name="council_number" />
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="form-group row">
							<div class="col-lg-12">
								<div class="row">
									<label for="street_address" class="col-lg-2 col-form-label">Home Address:</label>
									<div class="col-lg-10">
										<input class="form-control" type="text" id="street_address" name="street_address" />
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="form-group row">
							<div class="col-lg-4">
								<div class="row">
									<label for="city" class="col-lg-3 col-form-label">City:</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" id="city" name="city" />
									</div>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="row">
									<label for="state" class="col-lg-3 col-form-label">ST:</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" id="state" name="state" />
									</div>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="row">
									<label for="zip" class="col-lg-3 col-form-label">Zip:</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" id="zip" name="zip" />
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="row">
									<label for="phone" class="col-lg-3 col-form-label">Phone:</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" id="phone" name="phone" />
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="form-group row">
							<div class="col-lg-12">
								<div class="row">
									<label for="email_address" class="col-lg-2 col-form-label">Email Address:</label>
									<div class="col-lg-10">
										<input class="form-control" type="text" id="email_address" name="email_address" />
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-lg-12">
								<label>Position (please choose one for each registrant...non-Knights registering should choose "Other"):</label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-3">
								<div class="form-check">
									<label class="small form-check-label">
										<input class="form-check-input" type="checkbox" value="" /> Delegate
									</label>
								</div>
								<div class="form-check">
									<label class="small form-check-label">
										<input class="form-check-input" type="checkbox" value="" /> Supreme
									</label>
								</div>
								<div class="form-check">
									<label class="small form-check-label">
										<input class="form-check-input" type="checkbox" value="" /> State Director
									</label>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-check">
									<label class="small form-check-label">
										<input class="form-check-input" type="checkbox" value="" /> State Officer
									</label>
								</div>
								<div class="form-check">
									<label class="small form-check-label">
										<input class="form-check-input" type="checkbox" value="" /> Insurance Agent
									</label>
								</div>
								<div class="form-check">
									<label class="small form-check-label">
										<input class="form-check-input" type="checkbox" value="" /> State Chairman
									</label>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-check">
									<label class="small form-check-label">
										<input class="form-check-input" type="checkbox" value="" /> Past State Deputy
									</label>
								</div>
								<div class="form-check">
									<label class="small form-check-label">
										<input class="form-check-input" type="checkbox" value="" /> K of C Member
									</label>
								</div>
								<div class="form-group form-check">
									<label class="small form-check-label">
										<input id="check_other" class="form-check-input" type="checkbox" value="" /> Other
										<input id="text_other" class="form-control" readonly="true" type="text" />
									</label>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group form-check">
									<label class="small form-check-label">
										<input id="check_district" class="form-check-input" type="checkbox" value="" /> District Deputy #
										<input id="text_district" class="form-control" readonly="true" type="text" />
									</label>
								</div>
								<div class="form-group form-check">
									<label class="small form-check-label">
										<input id="check_chaplain" class="form-check-input" type="checkbox" value="" /> Clergy / Chaplain Council #
										<input id="text_chaplain" class="form-control" readonly="true" type="text" />
									</label>
								</div>
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="col-lg-12">
								<h2 class="center">Advance Event Ticket Purchases</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<label class="emphasis">Event</label>
							</div>
							<div class="col-lg-2">
								<label class="emphasis">Cost</label>
							</div>
							<div class="col-lg-3">
								<label class="emphasis"># of Tickets</label>
							</div>
							<div class="col-lg-3">
								<label class="emphasis">Total Due</label>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<label>Italian Dinner - Friday, May 5th</label>
							</div>
							<div class="col-lg-2">
								<label>$15.00</label>
							</div>
							<div class="col-lg-3">
								<input type="text" />
							</div>
							<div class="col-lg-3">
								<input type="text" />
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<label>Ladies Luncheon - Saturday, May 6th</label>
							</div>
							<div class="col-lg-2">
								<label>$15.00</label>
							</div>
							<div class="col-lg-3">
								<input type="text" />
							</div>
							<div class="col-lg-3">
								<input type="text" />
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<label>Convention Banquet - Saturday, May 6th</label>
							</div>
							<div class="col-lg-2">
								<label>$30.00</label>
							</div>
							<div class="col-lg-3">
								<input type="text" />
							</div>
							<div class="col-lg-3">
								<input type="text" />
							</div>
						</div>
					</form>
				</div>