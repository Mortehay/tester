<template>
    <div>
        lang switcher test {{currentLang}}
        <ul>
            <li v-for="lang in langs">
                <a v-on:click="langChange" :data-lang="lang" :class="{ 'uk-active' : lang != currentLang , 'uk-disabled' : lang == currentLang}">{{lang.toUpperCase()}}</a>
            </li>
        </ul>
    </div>

</template>

<script>
    export default {
        name: "lang",
        data() {
            return {
                langs:[],
                lang:'',
                currentLang:'',
            };
        },
        created() {
            this.fetchLangs();
        },
        methods:{
            fetchLangs(){
                let vm = this;

                let page_url = '/api/langs';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res =>{
                        //console.log(res);
                        this.langs = res;
                        let currentLang = (window.location.pathname).split('/')[1];
                        if((this.langs).indexOf(currentLang) > -1) {
                            this.currentLang = currentLang;
                        } else {
                            this.currentLang = 'en';
                        }
                    })
                    .catch(err => console.log(err));
                /**/
            },
            langChange(event){
                //console.log('lang', event.target.dataset.lang);
                let vm = this;
                let lang = event.target.dataset.lang;
                this.lang = lang;

                let currentLang = (window.location.pathname).split('/')[1];
                if((this.langs).indexOf(currentLang) > -1) {
                    this.currentLang = currentLang;
                } else {
                    this.currentLang = 'en';
                }
                if(this.currentLang != this.lang){

                    let page_url = `/api/langs/${lang}`;
                    console.log('fetch');
                    fetch(page_url)
                        .then(res => res.json())
                        .then(res =>{
                            console.log(res);
                            //if(res.data == 'success')
                            //this.langs = res;
                        })
                        .catch(err => console.log(err));
                }

            }
        }
    }
</script>

<style scoped>

</style>