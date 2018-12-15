<template>
    <vue-clip :options="options" :on-sending="sending" :on-added-file="addedFile" :on-complete="complete">

        <template slot="clip-uploader-action">
            <div class="uploader-action uploader" style="display:block">
                <div class="dz-message">
                    Click or Drag and Drop files here upload (Max file size {{ this.options.maxFilesize.limit }} MB)
                </div>
            </div>
        </template>

        <template slot="clip-uploader-body" slot-scope="props">
            <div class="uploader-files" v-if="files.length > 0">
                <div v-for="(file, index) in files">
                    <div class="uploader-file brdr1 br3px brdr-grey-light mb15 pt15 pl15 pr15 flex jcsb">
                        <!--<div class="file-avatar pull-left">-->
                        <!--<img v-bind:src="file.dataUrl" alt=""/>-->
                        <!--</div>-->

                        <div class="ml15 flex aic">
                            <div class="mr20">
                                <svg
                                        v-if="file.status === 'success'"
                                        width="17"
                                        height="17"
                                        class="w16px h16px f-grey-light"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 17 17">
                                    <path d="M15.418 1.774l-8.833 13.485-4.918-4.386 0.666-0.746 4.051 3.614 8.198-12.515 0.836 0.548z"/>
                                </svg>
                                <svg
                                        v-if="file.status === 'error'"
                                        width="17"
                                        height="17"
                                        class="w16px h16px f-red"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 17 17">
                                    <path d="M8.454 1.492l-8.242 14.508h16.581l-8.339-14.508zM8.459 3.508l6.605 11.492h-13.134l6.529-11.492zM9 10.938h-1v-3.938h1v3.938zM9.5 13.031c0 0.552-0.447 1-1 1s-1-0.448-1-1 0.447-1 1-1 1 0.448 1 1z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="file-details">
                                    <div class="file-name">
                                        {{ file.name }}
                                    </div>
                                </div>

                                <div class="file-progress" v-if="file.status !== 'error' && file.status !== 'success'">
                                    <span class="progress-indicator" v-bind:style="{width: file.progress + '%'}"></span>
                                </div>

                                <div class="file-meta" v-else>
                                    <span class="file-size">{{ bytesToSize(file.size) }}</span>
                                    <span class="file-status">
                                        <strong>
                                            <span v-if="file.status === 'success'">Upload Complete</span>
                                            <span v-else>{{ file.status }}</span>
                                            <span v-if="file.status === 'error'">:
                                                <span v-if="file.errorMessage.message">{{ file.errorMessage.message }}</span>
                                                <span v-else>{{ file.errorMessage }}</span>
                                            </span>
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <a
                                    v-if="(file.status === 'error' || file.status === 'success') && showAttachmentList === true"
                                    @click="clearFile(index)"
                                    class="btn btn-default"
                                    href="#">
                                <svg version="1.1" width="17" height="17" class="w12px h12px f-grey"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     viewBox="0 0 17 17">
                                    <path d="M9.207 8.5l6.646 6.646-0.707 0.707-6.646-6.646-6.646 6.646-0.707-0.707 6.646-6.646-6.647-6.646 0.707-0.707 6.647 6.646 6.646-6.646 0.707 0.707-6.646 6.646z"/>
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </template>

    </vue-clip>
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

        data() {
            var vm = this;
            return {
                files: [],
                uploader_copy: '',
                options: {
                    url: '/attachment/' + this.type + '/' + this.id,
                    paramName: 'file',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token needs to be set in layout meta
                    },
                    maxFilesize: {
                        limit: 25,
                        message: 'File size is greater than allowed.'
                    }
                },

            }
        },
        methods: {
            addedFile(file) {
                this.files.push(file)
            },

            /**
             *  Run on sending of file upload
             */
            sending(file, xhr, formData) {

                if (this.group !== null) {
                    formData.append('group', this.group)
                }
            },

            /**
             *  Run on completion of file upload
             */
            complete(file, status, xhr) {
                if (status === 'success') {
                    // this.$parent.$emit('addedAttachment');
                    this.$parent.$emit('refreshAttachments');
                    
                    swal({
                        title: "Upload Successful!",
                        text: this.sweetAlertMessage,
                        type: "success",
                        confirmButtonColor: "#66cc99"
                    });
                }
            },

            clearFile(index) {
                this.$delete(this.files, index)
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
            }
        },
        computed: {
            sweetAlertMessage: function () {
                if (this.group !== null) {
                    return "Thank you. We've received your "+this.group+" upload.";
                }
                return "Thank you. We've received your submission.";
            }
        }
    }
</script>
