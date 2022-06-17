(() => {
	/**
	 * @class Fields.DateField
	 */
	class DateField extends Fields.BaseField
	{
		getConfig()
		{
			const config = super.getConfig();

			return {
				...config,
				datePickerType: BX.prop.getString(config, 'datePickerType', 'date'),
				dateFormat: BX.prop.getString(config, 'dateFormat', 'd MMMM yyyy')
			};
		}

		renderReadOnlyContent()
		{
			if (this.isEmpty())
			{
				return this.renderEmptyContent();
			}

			return Text(
				{
					style: this.styles.value,
					text: this.getFormattedDate(this.props.value)
				}
			);
		}

		renderEditableContent()
		{
			if (this.isEmpty())
			{
				return Text(
					{
						style: this.styles.emptyValue,
						text: BX.message('FIELDS_DATE_CHOOSE_DATE')
					}
				);
			}

			return Text(
				{
					style: this.styles.value,
					text: this.getFormattedDate(this.props.value)
				}
			);
		}

		focus()
		{
			super.focus();

			dialogs.showDatePicker(
				{
					type: this.getConfig().datePickerType,
					value: this.setTimeToMilliseconds(this.props.value) || Date.now()
				},
				(eventName, newTs) => {
					this.removeFocus(() => {
						if (newTs  > 0)
						{
							this.handleChange(this.setTimeToSeconds(newTs));
						}
					});
				}
			);
		}

		getFormattedDate(date)
		{
			if (!date)
			{
				return '';
			}

			return DateFormatter.getDateString(this.props.value, this.getConfig().dateFormat)
		}

		setTimeToMilliseconds(value)
		{
			return value * 1000;
		}

		setTimeToSeconds(value)
		{
			return Math.floor(value / 1000);
		}

		showEditIcon()
		{
			return BX.prop.getBoolean(this.props, 'showEditIcon', true);
		}

		renderEditIcon()
		{
			return Image(
				{
					style: {
						height: 24,
						width: 24
					},
					svg: {
						content: `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.8749 17.7989H6.13115V9.05679H17.8749V17.7989ZM16.8125 6.24296V5.69268H18.0364C19.154 5.76311 20.0198 6.73271 19.9997 7.8938V18.8994C19.9997 19.5069 19.5248 20 18.9373 20H5.06876C4.48232 20 4.00638 19.5069 4.00638 18.8994V7.8938C4.00213 7.83657 4 7.78044 4 7.72431C4.00213 6.59954 4.88391 5.69047 5.96967 5.69268H7.19354V6.24296C7.19354 7.15422 7.9064 7.8938 8.78712 7.8938C9.66784 7.8938 10.3807 7.15422 10.3807 6.24296V5.69268H13.6253V6.24296C13.6253 7.15422 14.3392 7.8938 15.2189 7.8938C16.0986 7.8938 16.8125 7.15422 16.8125 6.24296ZM9.56798 4.81443V6.02505C9.56798 6.47187 9.21845 6.83396 8.78712 6.83396C8.35579 6.83396 8.00627 6.47187 8.00627 6.02505V4.81443V4.80342C8.00839 4.35769 8.3611 3.99781 8.79243 4.00001C9.22376 4.00331 9.5701 4.3676 9.56798 4.81443ZM15.9562 4.84414V5.99203C15.9562 6.41354 15.6258 6.75582 15.2178 6.75582C14.8099 6.75472 14.4816 6.41244 14.4816 5.99093V4.84414C14.4816 4.42153 14.812 4.08035 15.2189 4.08035C15.6258 4.08035 15.9562 4.42153 15.9562 4.84414ZM8.53434 11.0273C8.2582 11.0273 8.03434 11.2511 8.03434 11.5273V12.524C8.03434 12.8001 8.2582 13.024 8.53434 13.024H9.54421C9.82035 13.024 10.0442 12.8001 10.0442 12.524V11.5273C10.0442 11.2511 9.82035 11.0273 9.54421 11.0273H8.53434ZM8.53434 14.0223C8.2582 14.0223 8.03434 14.2461 8.03434 14.5223V15.519C8.03434 15.7951 8.2582 16.019 8.53434 16.019H9.54421C9.82035 16.019 10.0442 15.7951 10.0442 15.519V14.5223C10.0442 14.2461 9.82035 14.0223 9.54421 14.0223H8.53434ZM11.0491 11.5273C11.0491 11.2511 11.273 11.0273 11.5491 11.0273H12.559C12.8351 11.0273 13.059 11.2511 13.059 11.5273V12.524C13.059 12.8001 12.8351 13.024 12.559 13.024H11.5491C11.273 13.024 11.0491 12.8001 11.0491 12.524V11.5273ZM11.5491 14.0223C11.273 14.0223 11.0491 14.2461 11.0491 14.5223V15.519C11.0491 15.7951 11.273 16.019 11.5491 16.019H12.559C12.8351 16.019 13.059 15.7951 13.059 15.519V14.5223C13.059 14.2461 12.8351 14.0223 12.559 14.0223H11.5491ZM14.0639 11.5273C14.0639 11.2511 14.2878 11.0273 14.5639 11.0273H15.5738C15.8499 11.0273 16.0738 11.2511 16.0738 11.5273V12.524C16.0738 12.8001 15.8499 13.024 15.5738 13.024H14.5639C14.2878 13.024 14.0639 12.8001 14.0639 12.524V11.5273Z" fill="#CED4DA"/></svg>`
					}
				}
			)
		}
	}

	this.Fields = this.Fields || {};
	this.Fields.DateField = DateField;
})();
