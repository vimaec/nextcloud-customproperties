<template>
	<section class="section">
		<h2>Club Custom Properties</h2>
		<p class="settings-hint">
			{{
				t('customproperties', 'Custom Properties defined here are available to all users. They are shown in "Properties" tab in sidebar view. They can be accessed via WebDAV. Deleting properties will not wipe property values.')
			}}
		</p>
		<div>
			<CreateCustomPropertyForm @createProperty="createProperty" category="Club" />

			<hr>
			<template v-if="clubproperties.length > 0">
				<template v-for="property in clubproperties">
					<EditCustomPropertyForm :key="property.id"
						:property="property"
						@deleteProperty="deleteProperty"
						@updateProperty="updateProperty" />
				</template>
			</template>
			<EmptyPropertiesPlaceholder v-else />
		</div>

		<h2>Project Custom Properties</h2>
		<p class="settings-hint">
			{{
				t('customproperties', 'Custom Properties defined here are available to all users. They are shown in "Properties" tab in sidebar view. They can be accessed via WebDAV. Deleting properties will not wipe property values.')
			}}
		</p>
		<div>
			<CreateCustomPropertyForm @createProperty="createProperty" category="Project" />

			<hr>
			<template v-if="projectproperties.length > 0">
				<template v-for="property in projectproperties">
					<EditCustomPropertyForm :key="property.id"
						:property="property"
						@deleteProperty="deleteProperty"
						@updateProperty="updateProperty" />
				</template>
			</template>
			<EmptyPropertiesPlaceholder v-else />
		</div>

		<h2>Rest Custom Properties</h2>
		<p class="settings-hint">
			{{
				t('customproperties', 'Custom Properties defined here are available to all users. They are shown in "Properties" tab in sidebar view. They can be accessed via WebDAV. Deleting properties will not wipe property values.')
			}}
		</p>
		<div>
			<CreateCustomPropertyForm @createProperty="createProperty" category="Rest" />

			<hr>
			<template v-if="restproperties.length > 0">
				<template v-for="property in restproperties">
					<EditCustomPropertyForm :key="property.id"
						:property="property"
						@deleteProperty="deleteProperty"
						@updateProperty="updateProperty" />
				</template>
			</template>
			<EmptyPropertiesPlaceholder v-else />
		</div>
	</section>
</template>

<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import '@nextcloud/dialogs/styles/toast.scss'
import CreateCustomPropertyForm from '../../components/customPropertyForm/CreateCustomPropertyForm'
import EditCustomPropertyForm from '../../components/customPropertyForm/EditCustomPropertyForm'
import EmptyPropertiesPlaceholder from '../../components/emptypropertiesplaceholder/EmptyPropertiesPlaceholder'

export default {
	name: 'AdminSettings',
	components: {
		EmptyPropertiesPlaceholder,
		EditCustomPropertyForm,
		CreateCustomPropertyForm,
	},
	data() {
		return {
			icon: 'icon-info',
			loading: true,
			name: t('customproperties', 'Properties'),
			clubproperties: [],
			projectproperties: [],
			restproperties: []
		}
	},
	computed: {
		id() {
			return this.name.toLowerCase().replace(/ /g, '-')
		},
		activeTab() {
			return this.$parent.activeTab
		},
	},
	created() {
		this.getDataFromApi()
	},
	methods: {
		async getDataFromApi() {
			const url = generateUrl('/apps/customproperties/customproperties')
			const res = await axios.get(url)
			this.restproperties = res.data

			const url1 = generateUrl('/apps/customproperties/customproperties?category=Club')
			const res1 = await axios.get(url1)
			this.clubproperties = res1.data

			const url2 = generateUrl('/apps/customproperties/customproperties?category=Project')
			const res2 = await axios.get(url2)
			this.projectproperties = res2.data
		},
		async deleteProperty(id) {
			const url = generateUrl(`/apps/customproperties/customproperties/${id}`)
			await axios.delete(url)
			await this.getDataFromApi()
			showSuccess(this.t('customproperties', 'Custom Property has been deleted!'))
		},
		async updateProperty(customProperty) {
			const url = generateUrl('/apps/customproperties/customproperties')
			await axios.post(url, { customProperty })
			await this.getDataFromApi()
			showSuccess(this.t('customproperties', 'Custom Property has been changed!'))
		},
		async createProperty(customProperty) {
			const url = generateUrl('/apps/customproperties/customproperties')
			try {
				await axios.put(url, { customProperty })
				await this.getDataFromApi()
				showSuccess(this.t('customproperties', 'New Custom Property has been added!'))
			} catch (e) {
				console.error(e)
				showError(t('customproperties', 'Error saving property, please check constraints.'))
			}
		},
	},
}
</script>

<style lang="scss" scoped>
.customproperty-empty {
  border: 1px solid var(--color-border-dark);
  padding: .5rem 1rem;
  color: #ccc;
}
</style>
