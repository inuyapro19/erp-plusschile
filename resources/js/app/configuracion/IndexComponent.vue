<template>
    <CardComponent :title="'Configuraciones'">
        <template #body>
            <tabs-Container>
                <template #tabs>
                    <li class="nav-item" v-for="(tab, index) in tabs" :key="tab.id">
                        <a :class="['nav-link', { 'active': tab.active }]"
                           :id="`${tab.id}-tab`"
                           data-toggle="tab"
                           :href="tab.href"
                           role="tab"
                           :aria-controls="tab.ariaControls"
                           :aria-selected="tab.ariaSelected"
                           @click="changeTab(index)">
                            {{ tab.title }}
                        </a>
                    </li>
                </template>
                <template #tab-content>
                    <div v-for="tabContent in tabContents" :key="tabContent.id"
                         :class="['tab-pane', 'fade', { 'show active': tabContent.active }]"
                         :id="tabContent.id" role="tabpanel"
                         :aria-labelledby="tabContent.ariaLabelledby">
                        <component :is="tabContent.component"></component>
                    </div>
                </template>
            </tabs-Container>
        </template>
    </CardComponent>
</template>

<script>
import {tabs,tabContent} from "../../data/tabData";
import CardComponent from "../../components/CardComponent.vue";
import TabsContainer from "../../components/TabsContainer.vue";

import Prevision from './formularios/Prevision';
import Salud from './formularios/Salud';
import Cargos from './formularios/Cargos';
import Nacionalidades from './formularios/Nacionalidades';
import Ubicaciones from './formularios/Ubicaciones';
import Bancos from './formularios/Bancos';
import Empleador from './formularios/Empleador';
import Areas from './formularios/Areas';
import Motivos from './formularios/Motivos';
import PrevisionInp from './formularios/PrevisionInp';
import Oficinas from './formularios/Oficinas';

export default {
    components:{
        Prevision,
        Salud,
        Cargos,
        Nacionalidades,
        Ubicaciones,
        Bancos,
        Empleador,
        Areas,
        Motivos,
        PrevisionInp,
        Oficinas,
        CardComponent,
        TabsContainer
    },
    data() {
        return {
            tabs: tabs,
            tabContents: tabContent
        }
    },
    methods: {
        changeTab(index) {
            this.tabs.forEach((tab, i) => {
                tab.active = i === index;
            });
            this.tabContents.forEach((content, i) => {
                content.active = i === index;
            });
        }
    }
}
</script>

<style scoped>

</style>
