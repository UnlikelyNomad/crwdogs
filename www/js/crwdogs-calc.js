var Calcs = {
    sizes: [113, 126, 143, 160, 176, 193, 218],

    loading: function(weight, canopy_size) {
        return weight / canopy_size;
    },

    lightningSize: function(weight, wingloading) {
        var ideal = weight / (wingloading + .02);

        for (var i = 0; i < this.sizes.length; ++i) {
            if (this.sizes[i] > ideal) {
                return this.sizes[i];
            }
        }

        return this.sizes[this.sizes.length - 1];
    },

    containerMin: function(canopy_size) {
        return Math.ceil(canopy_size / 10) * 10;
    },

    containerMax: function(canopy_size) {
        return this.containerMin(canopy_size) + 20;
    },

    dec: function (val, prec) {
        var p = Math.pow(10, prec);
        return Math.round(val * p) / p;
    }
};