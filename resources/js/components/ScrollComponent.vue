<template>
    <div>
        <a if="display" uk-icon="chevron-up" v-scroll-to="{ el: '#app', offset: -70, }">{{ $t('texts.scroll.title')}}</a>
        <!--<br> Window height: {{ windowHeight }} <br/>
        {{ txt }}-->
    </div>
</template>

<script>
    export default {
        name: "scroll",
        props:{

        },
        data() {
            return {
                windowHeight: 0,
                txt: '',
                display: false,
            };
        },
        mounted() {
            this.windowHeight = window.innerHeight;
            this.$nextTick(() => {
                window.addEventListener('scroll', () => {
                    this.windowHeight = window.innerHeight
                });
            })
        },
        beforeDestroy() {
            window.removeEventListener('scroll', this.onScrollFunction);
        },
        methods:{

        },
        watch:{
            windowHeight(newHeight, oldHeight) {
                //this.txt = `it changed to ${newHeight} from ${oldHeight}`;
                if(newHeight > oldHeight) this.display = true;
            }
        }
    }
</script>

<style scoped>

</style>