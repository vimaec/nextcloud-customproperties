<template>
	<div class="customproperty-form-group">
		<label :for="'property_'+property_.propertyname">{{ property_.propertylabel }}<span v-if="property_.propertyisrequired" style="color: red;">*</span></label>
		<div v-if="property_.propertytype === 'textarea'" class="customproperty-input-group">
			<textarea :id="'textproperty_'+property_.propertyname"
				v-model="property_.propertyvalue"
				:name="property_.propertyname"
				:required="property_.propertyisrequired"
				class="customproperty-form-control"
				rows="6"
				@blur="blur"></textarea>
		</div>

		<div v-else class="customproperty-input-group">
			<input :id="'property_'+property_.propertyname"
				v-model="property_.propertyvalue"
				:aria-disabled="disabled"
				:disabled="disabled"
				:required="property_.propertyisrequired"
				:name="property_.propertyname"
				:type="property_.propertytype"
				class="customproperty-form-control"
				@blur="blur">
		</div>
	</div>
</template>

<script>
export default {
	name: 'PropertyTextInput',
	model: {
		prop: 'property',
	},
	props: {
		property: {
			type: Object,
			required: true,
		},
		disabled: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			property_: this.property,
		}
	},
	methods: {
		blur() {
			this.$emit('blur', this.property_)
		},
	},
}
</script>
