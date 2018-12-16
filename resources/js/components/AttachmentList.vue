<template>
    <div class="pa30 table-responsive">
        <table
                v-if="attachments.length > 0"
                class="table table-bordred table-striped mb0">
            <thead>
            <tr>
                <th>File Name</th>
                <th v-if="this.group">Group</th>
                <th>Size</th>
                <th>Type</th>
                <th>Created</th>
                <th></th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr v-if="loadingAttachments">
                <td colspan=100>
                    <div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>
                </td>
            </tr>
            <tr v-for="attachment in showAttachments" v-if="!loadingAttachments">

                <!--  File Name -->
                <td>
                    {{ attachment.filename }}
                </td>

                <!--  Group -->
                <td v-if="group">
                    <div v-if="attachment.group">
                        {{ attachment.group }}
                    </div>
                    <div v-else>
                        --
                    </div>
                </td>

                <!-- Size -->
                <td>
                    {{ bytesToSize(attachment.filesize) }}
                </td>

                <!-- Type -->
                <td>
                    {{ attachment.filetype }}
                </td>

                <!-- Created At -->
                <td>
                    {{ formatDate(attachment.created_at) }}
                </td>

                <!-- Download Button -->
                <td>
                    <a :href="attachment.url" class="btn btn-labeled btn-primary mb0 mt10 mb10">
                        <span class="btn-label">
                            <svg width="17" height="17" class="w12px h12px f-white" viewBox="0 0 17 17"><path
                                    d="M17 16v1h-17v-1h17zM13.354 8.854l-0.707-0.707-3.646 3.646v-11.793h-1v11.794l-3.647-3.648-0.708 0.708 4.854 4.853 4.854-4.853z"/>
                            </svg>
                        </span>
                        <span class="ft14 fw4 text-transform-none">Download</span>
                    </a>
                </td>

                <!-- Edit Button -->
                <!--<td>-->
                <!--<button class="btn btn-primary" @click=""-->
                <!--v-if=""><i class="fa fa-edit"></i>-->
                <!--</button>-->
                <!--</td>-->

                <!-- Delete Button -->
                <td>
                    <a
                            v-if="canDeleteAttachment(attachment)"
                            @click="approveAttachmentDelete(attachment)"
                            class="tc-red"
                            href="#">
                        (delete)
                    </a>
                </td>

            </tr>
            </tbody>
        </table>

        <!-- Delete Token Modal -->
        <div class="modal" :id="'modal-delete-attachment-' + this.type + '-' + this.id" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document" v-if="deletingAttachment">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">Delete Attachment</h5>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete the attachment <strong>"{{ deletingAttachment.filename
                        }}"</strong>?
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No, Go Back</button>
                        <button type="button" class="btn btn-danger" @click="deleteAttachment" :disabled="deleteAttachmentForm.busy">
                            <span v-if="deleteAttachmentForm.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i>Deleting Attachment
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
</template>

<script>
    export default {
        props: {
            'id': Number,
            'type': String,
            'group': {
                type: String,
                default: null
            },
            'showAttachmentList': {
                type: Boolean,
                default: true
            }
        },

        /**
         * The component's data.
         */
        data() {
            return {
                attachments: [],
                filteredAttachments: [],
                loadingAttachments: false,
                deletingAttachment: null,
                deleteAttachmentForm: new SparkForm({}),
            };
        },

        /**
         * Bootstrap the component.
         */

        mounted() {
            this.getAttachments();
        },

        created() {
            let self = this;

            // Refresh Attachments
            this.$parent.$on('refreshAttachments', function () {
                self.getAttachments();
            });
        },

        methods: {

            /**
             * Get all attachments for object.
             */
            getAttachments() {
                this.loadingAttachments = true;
                if (this.showAttachmentList === true) {

                    var url = '/attachment/' + this.type + '/' + this.id;

                    if (this.group !== null) {
                        url += '/' + this.group;
                    }

                    axios.get(url)
                        .then(response => {
                            this.attachments = response.data;
                            this.loadingAttachments = false;
                        })
                }
            },

            /**
             * Get user confirmation that the attachment should be deleted.
             */
            approveAttachmentDelete(attachment) {
                this.deletingAttachment = attachment;

                $('#modal-delete-attachment-' + this.type + '-' + this.id).modal('show');
            },

            /**
             * Delete the specified attachment.
             */
            deleteAttachment() {
                Spark.delete('/attachment/' + this.deletingAttachment.uuid, this.deleteAttachmentForm)
                    .then(() => {
                        this.getAttachments();
                        $('#modal-delete-attachment-' + this.type + '-' + this.id).modal("hide");
                    });
            },

            canDeleteAttachment(attachment) {
                return true;
            },
            bytesToSize(bytes) {
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

                if (bytes === 0) {
                    return 'n/a';
                }

                const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);

                if (i === 0) {
                    return `${bytes} ${sizes[i]}`;
                }

                return `${(bytes / (1024 ** i)).toFixed(1)} ${sizes[i]}`;
            },

            formatDate(value) {
                return moment.utc(value).local().format('M/D/YYYY h:mm A');
            }
        },
        computed: {
            showAttachments: function () {

                // Show default
                return this.attachments;
            }
        }
    }
</script>
