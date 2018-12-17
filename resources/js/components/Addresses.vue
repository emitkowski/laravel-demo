<template>
    <div class="panel brdr-grey-light">
        <div class="br3px--tr br3px--tl pt10 pr15 pb10 pl15 bc-blue-light tc-white brdr1--bottom brdr-grey-light flex jcsb aic">
            <div class="panel-title flex aic">
                <svg width="2048" height="1792" class="w16px h16px mr5 f-white" viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1024 1131q0 64-37 106.5t-91 42.5h-512q-54 0-91-42.5t-37-106.5 9-117.5 29.5-103 60.5-78 97-28.5q6 4 30 18t37.5 21.5 35.5 17.5 43 14.5 42 4.5 42-4.5 43-14.5 35.5-17.5 37.5-21.5 30-18q57 0 97 28.5t60.5 78 29.5 103 9 117.5zm-157-520q0 94-66.5 160.5t-160.5 66.5-160.5-66.5-66.5-160.5 66.5-160.5 160.5-66.5 160.5 66.5 66.5 160.5zm925 445v64q0 14-9 23t-23 9h-576q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h576q14 0 23 9t9 23zm0-252v56q0 15-10.5 25.5t-25.5 10.5h-568q-15 0-25.5-10.5t-10.5-25.5v-56q0-15 10.5-25.5t25.5-10.5h568q15 0 25.5 10.5t10.5 25.5zm0-260v64q0 14-9 23t-23 9h-576q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h576q14 0 23 9t9 23zm128 960v-1216q0-13-9.5-22.5t-22.5-9.5h-1728q-13 0-22.5 9.5t-9.5 22.5v1216q0 13 9.5 22.5t22.5 9.5h352v-96q0-14 9-23t23-9h64q14 0 23 9t9 23v96h768v-96q0-14 9-23t23-9h64q14 0 23 9t9 23v96h352q13 0 22.5-9.5t9.5-22.5zm128-1216v1216q0 66-47 113t-113 47h-1728q-66 0-113-47t-47-113v-1216q0-66 47-113t113-47h1728q66 0 113 47t47 113z"/></svg>
                <span>
                    Manage Addresses <span v-if="name">for {{ name }}</span>
                </span>
            </div>
        </div>

        <div class="panel-body table-responsive">
            
            <div 
                v-if="addresses.length > 0"
                class="pt30 pl30 pr30 pb10 table-responsive">
                <table class="table table-bordred table-striped mb0">
                    <thead>
                        <tr>
                            <th>Default</th>
                            <th>Type</th>
                            <th>Address</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                    <tr v-if="loadingAddresses">
                        <td colspan=100>
                            <div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
                        </td>
                    </tr>
                    <tr v-for="address in addresses" v-if="!loadingAddresses" class="">
                        <!-- Default -->
                        <td>
                            <div class="">
                                <span v-if="address.default === 1">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w16px h16px f-grey-dark ml5" width="17" height="17" viewBox="0 0 17 17">
                                        <path d="M14 5.761h1v10.239h-14v-14h8.393v1h-7.393v12h12v-9.239zM4.854 8.146l-0.708 0.708 3.434 3.434 7.587-11.512-0.835-0.551-6.912 10.488-2.566-2.567z"  />
                                    </svg>
                                </span>
                            </div>
                        </td>

                        <!--  Type -->
                        <td>
                            <div class="">
                                {{ address.type | capitalize }}
                            </div>
                        </td>

                        <!-- Address -->
                        <td>
                            <div v-html="formatAddress(address)"></div>
                        </td>

                        <!-- Actions-->
                        <td>
                            <a 
                                @click="showAddressForm(address)" 
                                v-if="canEditAddress(address)"
                                href="#"
                                class="btn btn-labeled btn-primary mt10 mb10">
                                <span class="btn-label ">
                                    <svg width="1792" height="1792" class="w12px h12px f-white" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M491 1536l91-91-235-235-91 91v107h128v128h107zm523-928q0-22-22-22-10 0-17 7l-542 542q-7 7-7 17 0 22 22 22 10 0 17-7l542-542q7-7 7-17zm-54-192l416 416-832 832h-416v-416zm683 96q0 53-37 90l-166 166-416-416 166-165q36-38 90-38 53 0 91 38l235 234q37 39 37 91z"/></svg>
                                 </span> 
                                <span class="ft14 fw4 text-transform-none">Edit</span>
                            </a>
                        </td>
                        <td>
                            <a 
                                @click="approveAddressDelete(address)"
                                v-if="canDeleteAddress(address)" 
                                href="#"
                                class="tc-red">
                                (delete)
                            </a>
                        </td>
                        <td>
                            <a 
                                @click="makeAddressDefault(address)"
                                v-if="canEditAddress(address) && address.default !== 1"
                                href="#"
                                class="tc-grey">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w12px h12px f-grey" width="17" height="17" viewBox="0 0 17 17">
                                    <path d="M14 5.761h1v10.239h-14v-14h8.393v1h-7.393v12h12v-9.239zM4.854 8.146l-0.708 0.708 3.434 3.434 7.587-11.512-0.835-0.551-6.912 10.488-2.566-2.567z"  />
                                </svg>
                                <span class="ml5">set as default</span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <hr>
            </div>

            <div class="mt15 mb15">
                <button @click="showAddressForm()" class="btn btn-labeled btn-primary">
                    <span class="btn-label">
                        <svg width="1792" height="1792" class="w12px h12px f-white" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1600 736v192q0 40-28 68t-68 28h-416v416q0 40-28 68t-68 28h-192q-40 0-68-28t-28-68v-416h-416q-40 0-68-28t-28-68v-192q0-40 28-68t68-28h416v-416q0-40 28-68t68-28h192q40 0 68 28t28 68v416h416q40 0 68 28t28 68z"/></svg>
                     </span> 
                    <span class="">Add Address</span>
                </button>
            </div>

            <!-- Address Form Modal -->
            <div class="modal" :id="'modal-form-address-' + this.type + '-' + this.id" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Add Address</h4>
                        </div>

                        <div class="modal-body">
                            <form class="form-horizontal" role="form">

                                <!-- Type -->
                                <div class="form-group" :class="{'has-error': addressForm.errors.has('type')}">
                                    <label class="col-md-4 control-label">Type</label>

                                    <div class="col-md-6">
                                        <select class="form-control" v-model="addressForm.type">
                                            <option v-for="type in types" :value="type">
                                                {{ type | capitalize }}
                                            </option>
                                        </select>

                                        <span class="help-block" v-if="addressForm.errors.has('type')">
                                            {{ addressForm.errors.get('type') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Address Line 1 -->
                                <div class="form-group" :class="{'has-error': addressForm.errors.has('address')}">
                                    <label class="col-md-4 control-label">Address Line 1</label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" v-model="addressForm.address">

                                        <span class="help-block" v-show="addressForm.errors.has('address')">
                                            {{ addressForm.errors.get('address') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Address Line 2 -->
                                <div class="form-group" :class="{'has-error': addressForm.errors.has('address2')}">
                                    <label class="col-md-4 control-label">Address Line 2</label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" v-model="addressForm.address2">

                                        <span class="help-block" v-show="addressForm.errors.has('address2')">
                                            {{ addressForm.errors.get('address2') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="form-group" :class="{'has-error': addressForm.errors.has('city')}">
                                    <label class="col-md-4 control-label">City</label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" v-model="addressForm.city">

                                        <span class="help-block" v-show="addressForm.errors.has('city')">
                                            {{ addressForm.errors.get('city') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- State / ZIP Code -->
                                <div class="form-group" :class="{'has-error': addressForm.errors.has('state') || addressForm.errors.has('postal')}">
                                    <label class="col-md-4 control-label">State / Zip Code</label>

                                    <!-- State -->
                                    <div class="col-sm-6">
                                        <select class="form-control" v-model="addressForm.state">
                                            <option v-for="(name, abbreviation) in states" :value="abbreviation">
                                                {{ name }}
                                            </option>
                                        </select>

                                        <span class="help-block" v-show="addressForm.errors.has('state')">
                                            {{ addressForm.errors.get('state') }}
                                        </span>
                                    </div>

                                    <!-- Zip Code -->
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" v-model="addressForm.postal"
                                               placeholder="Zip Code">

                                        <span class="help-block" v-show="addressForm.errors.has('postal')">
                                            {{ addressForm.errors.get('postal') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Country -->
                                <!--<div class="form-group" :class="{'has-error': addressForm.errors.has('country')}">-->
                                    <!--<label class="col-md-4 control-label">Country</label>-->

                                    <!--<div class="col-sm-6">-->
                                        <!--<select class="form-control" v-model="addressForm.country">-->
                                            <!--<option v-for="(name, abbreviation) in countries" :value="abbreviation">-->
                                                <!--{{ name }}-->
                                            <!--</option>-->
                                        <!--</select>-->

                                        <!--<span class="help-block" v-show="addressForm.errors.has('country')">-->
                                            <!--{{ addressForm.errors.get('country') }}-->
                                        <!--</span>-->
                                    <!--</div>-->
                                <!--</div>-->

                            </form>
                        </div>

                        <!-- Modal Actions -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" v-if="editingAddress" @click="editAddress(editingAddress)" :disabled="addressForm.busy">
                                <span v-if="addressForm.busy">
                                    <i class="fa fa-btn fa-spinner fa-spin"></i>Updating Address
                                </span>
                                <span v-else>
                                    Update Address
                                </span>

                            </button>
                            <button type="button" class="btn btn-primary" v-if="!editingAddress" @click="createAddress" :disabled="addressForm.busy">
                                <span v-if="addressForm.busy">
                                    <i class="fa fa-btn fa-spinner fa-spin"></i>Adding Address
                                </span>
                                <span v-else>
                                    Add Address
                                </span>
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Address Modal -->
            <div class="modal" :id="'modal-delete-address-' + this.type + '-' + this.id" tabindex="-1"
                 role="dialog">
                <div class="modal-dialog" v-if="deletingAddress">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                            </button>
                            <h4 class="modal-title">
                                Delete Address
                            </h4>
                        </div>

                        <div class="modal-body">
                            Are you sure you want to delete the <strong>{{ deletingAddress.type | capitalize }}
                            Address:</strong><br><br>
                            <p v-html="formatAddress(deletingAddress)"></p>
                        </div>

                        <!-- Modal Actions -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No, Go Back</button>

                            <button type="button" class="btn btn-danger" @click="deleteAddress" :disabled="deleteAddressForm.busy">
                                <span v-if="deleteAddressForm.busy">
                                    <i class="fa fa-btn fa-spinner fa-spin"></i>Deleting Address
                                </span>
                                <span v-else>
                                    Yes, Delete
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['type', 'id', 'name'],

        /**
         * The component's data.
         */
        data() {
            return {
                types: ['mailing', 'billing', 'shipping', 'physical'],
                states:[],
                countries:[],
                addresses: [],
                loadingAddresses: false,
                editingAddress: null,
                deletingAddress: null,
                deleteAddressForm: new SparkForm({}),
                addressForm: new SparkForm({
                    type: '',
                    address: '',
                    address2: '',
                    city: '',
                    state: '',
                    postal: '',
                    postal_additional: '',
                    country: '',
                }),
            };
        },

        /**
         * Bootstrap the component.
         */

        mounted() {
            this.getAddresses();
            this.getStates();
            this.getCountries();
        },

        created() {
            let self = this;

            // Refresh Addresses
            this.$parent.$on('refreshAddresses', function () {
                self.getAddresses();
            });
        },

        methods: {

            /**
             * Get all addresses for object.
             */
            getStates() {
                axios.get('/geo/states')
                    .then(response => {
                        this.states = response.data.states;
                    })

            },

            /**
             * Get all addresses for object.
             */
            getCountries() {
                axios.get('/geo/countries')
                    .then(response => {
                        this.countries = response.data.countries;
                    })

            },

            /**
             * Get all addresses for object.
             */
            getAddresses() {
                this.loadingAddresses = true;
                axios.get('/address/' + this.type + '/' + this.id)
                    .then(response => {
                        this.addresses = response.data;
                        this.loadingAddresses = false;
                    })

            },

            /**
             * Create Formatted Address
             */
            formatAddress(address) {
                let formatted_address = '';

                if (address.addressee !== null) {
                    formatted_address += address.addressee + '<br>';
                }

                if (address.address !== null) {
                    formatted_address += address.address + '<br>';
                }

                if (address.address2 !== null) {
                    formatted_address += address.address2 + '<br>';
                }

                formatted_address += address.city + ', ' + address.state + ' ' + address.postal;

                if (address.postal_additional !== null) {
                    formatted_address += '-' + address.postal_additional;
                }

                if (address.country !== null) {
                    formatted_address += '<br>' + address.country;
                }

                return formatted_address;
            },

            showAddressForm(address = null) {

                this.resetAddressForm();

                if (address !== null) {
                    this.editingAddress = address;

                    this.addressForm.type = address.type;
                    this.addressForm.address = address.address;
                    this.addressForm.address2 = address.address2;
                    this.addressForm.city = address.city;
                    this.addressForm.state = address.state;
                    this.addressForm.postal = address.postal;
                    this.addressForm.postal_additional = address.postal_additional;
                    this.addressForm.country = address.country;
                } else {
                    this.editingAddress = null;
                }

                $('#modal-form-address-' + this.type + '-' + this.id).modal('show');
            },

            /**
             * Create new address
             */
            createAddress() {
                Spark.post('/address/' + this.type + '/' + this.id, this.addressForm)
                    .then(() => {
                        this.getAddresses();
                        $('#modal-form-address-' + this.type + '-' + this.id).modal('hide');
                    });
            },

            /**
             * Edit specified address
             */
            editAddress(address) {
                Spark.put('/address/' + address.id, this.addressForm)
                    .then(() => {
                        this.getAddresses();
                        $('#modal-form-address-' + this.type + '-' + this.id).modal('hide');
                    });
            },

            makeAddressDefault(address) {
                this.loadingAddresses = true;
                Spark.put('/address/default/' + address.id, this.addressForm)
                    .then(() => {
                        this.getAddresses();
                    });
            },

            /**
             * Get user confirmation that the address should be deleted.
             */
            approveAddressDelete(address) {
                this.deletingAddress = address;

                $('#modal-delete-address-' + this.type + '-' + this.id).modal('show');
            },


            /**
             * Delete the specified address.
             */
            deleteAddress() {
                Spark.delete('/address/' + this.deletingAddress.id, this.deleteAddressForm)
                    .then(() => {
                        this.getAddresses();

                        $('#modal-delete-address-' + this.type + '-' + this.id).modal('hide');
                    });
            },
            /**
             * Reset Address Form
             */
            resetAddressForm()
            {
                this.addressForm.resetStatus();

                this.addressForm.type = '';
                this.addressForm.address = '';
                this.addressForm.address2 = '';
                this.addressForm.city = '';
                this.addressForm.state = '';
                this.addressForm.postal = '';
                this.addressForm.postal_additional = '';
                this.addressForm.country = '';
            },

            canEditAddress(address) {
                return true;
            },
            canDeleteAddress(address) {
                return true;
            }
        }
    }
</script>
