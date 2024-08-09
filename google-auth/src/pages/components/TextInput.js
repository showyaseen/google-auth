const TextInput = ({ id, placeholder = '', label, value, onChange, type = 'text', help }) => (
	< div class="sui-form-field" >
		<label for={id} id={`label - ${id}`} class="sui-label" > {label} </label>
		<input
			placeholder={placeholder}
			id={id}
			type={type}
			value={value}
			onChange={onChange}
			class="sui-form-control"
			aria-labelledby="label-unique-id"
		/>

		{help && <span id="input-description" class="sui-description" > {help} </span>}

	</div>
);

export default TextInput;
