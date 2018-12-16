module.exports = {
    /**
     * Helper method for making POST HTTP requests.
     */
    post(uri, form, headers) {
        return Spark.sendForm('post', uri, form, headers);
    },


    /**
     * Helper method for making PUT HTTP requests.
     */
    put(uri, form, headers) {
        return Spark.sendForm('put', uri, form, headers);
    },


    /**
     * Helper method for making PATCH HTTP requests.
     */
    patch(uri, form, headers) {
        return Spark.sendForm('patch', uri, form, headers);
    },


    /**
     * Helper method for making DELETE HTTP requests.
     */
    delete(uri, form, headers) {
        return Spark.sendForm('delete', uri, form, headers);
    },


    /**
     * Send the form to the back-end server.
     *
     * This function will clear old errors, update "busy" status, etc.
     */
    sendForm(method, uri, form, headers) {
        return new Promise((resolve, reject) => {
            form.startProcessing();

            axios[method](uri, JSON.parse(JSON.stringify(form)), headers)
                .then(response => {
                    form.finishProcessing();

                    resolve(response.data);
                })
                .catch(errors => {
                    form.setErrors(errors.response.data.errors);

                    reject(errors.response.data);
                });
        });
    }
};
