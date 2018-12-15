<template>
    <div class="panel brdr-grey-light">
        <div class="br3px--tr br3px--tl pt10 pr15 pb10 pl15 bc-blue-light tc-white brdr1--bottom brdr-grey-light flex jcsb aic">
            <div class="panel-title flex aic">
                <svg width="1792" height="1792" class="w16px h16px mr5 f-white" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1600 1312v-704q0-40-28-68t-68-28h-704q-40 0-68-28t-28-68v-64q0-40-28-68t-68-28h-320q-40 0-68 28t-28 68v960q0 40 28 68t68 28h1216q40 0 68-28t28-68zm128-704v704q0 92-66 158t-158 66h-1216q-92 0-158-66t-66-158v-960q0-92 66-158t158-66h320q92 0 158 66t66 158v32h672q92 0 158 66t66 158z"/></svg>
                <span>
                    Files <span v-if="name">for {{ name }}</span>
                </span>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <uploader :type="type" :id="id" :group="group" :showAttachmentList="showAttachmentList"></uploader>
            <attachment-list :type="type" :id="id" :group="group" :showAttachmentList="showAttachmentList"></attachment-list>
        </div>
    </div>
</template>

<script>
    import Uploader from './Uploader.vue';
    import AttachmentList from './AttachmentList.vue';

    export default {

        props: {
            'id': Number,
            'type': String,
            'name': String,
            'group': {
                type: String,
                default: null
            },
            'showAttachmentList': {
                type: Boolean,
                default: true
            }
        },

        components: {
            'uploader': Uploader,
            'attachment-list': AttachmentList
        },

        created() {
            let self = this;

            // Handle New Attachment
            this.$on('addedAttachment', function () {
                this.$emit('refreshAttachments');
            });
        },

        data() {
            return {}
        },
        methods: {}
    }
</script>