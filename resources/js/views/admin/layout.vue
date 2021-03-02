<template>
    <!-- <v-container fluid class="pa-0"> -->
    <!-- <v-layout> -->
    <v-main>
        <!-- <v-row no-gutters>
            <v-col cols="12">
                <v-card> -->
        <!-- <v-app-bar color="deep-purple accent-4" dark prominent> -->
        <!-- <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon> -->
        <!-- drawer: {{ drawer }} -->
        <v-navigation-drawer
            fixed
            permanent
            clipped
            :mini-variant.sync="miniSidebar"
        >
            <v-list>
                <v-list-item class="px-2">
                    <v-list-item-avatar>
                        <v-img
                            src="https://randomuser.me/api/portraits/women/85.jpg"
                        ></v-img>
                    </v-list-item-avatar>
                </v-list-item>

                <v-list-item link>
                    <v-list-item-content>
                        <v-list-item-title class="title">
                            Sandra Adams
                        </v-list-item-title>
                        <v-list-item-subtitle
                            >sandra_a88@gmail.com</v-list-item-subtitle
                        >
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list nav dense>
                <v-list-item to="/admin/avocats">
                    <v-list-item-icon>
                        <v-icon>mdi-account-tie</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Avocats</v-list-item-title>
                </v-list-item>
                <v-list-item to="/admin/stagiaires">
                    <v-list-item-icon>
                        <v-icon>mdi-school</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Etudiants/Stagiaires</v-list-item-title>
                </v-list-item>
                <v-list-item to="/admin/permanences">
                    <v-list-item-icon>
                        <v-icon>mdi-calendar-month</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Permanences</v-list-item-title>
                </v-list-item>
                <v-list-item to="/admin/files">
                    <v-list-item-icon>
                        <v-icon>mdi-file</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Fichiers</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <!-- </v-app-bar> -->
        <!-- <v-icon large>mdi-menu</v-icon> -->

        <!-- <div style="width: 200px; border: 1px solid red;">
                        </div>-->
        <v-container
            fluid
            :class="[miniSidebar ? 'padding-left__small' : 'padding-left__big']"
        >
            <router-view></router-view>
        </v-container>
        <!-- </v-card> -->
        <!-- </v-col> -->
        <!-- <v-col>
                
            </v-col> -->
        <!-- </v-row> -->
        <!-- </v-container> -->
        <!-- </v-layout> -->
    </v-main>
</template>

<script>
export default {
    name: "AdminIndex",
    data() {
        return {
            // mini: true
            // drawer: false,
            // miniSidebar: false
        };
    },
    computed: {
        miniSidebar() {
            switch (this.$vuetify.breakpoint.name) {
                case "xs":
                    return true;
                case "sm":
                    return true;
                case "md":
                    return false;
                case "lg":
                    return false;
                case "xl":
                    return false;
            }
        }
    }
};
</script>

<style scoped>
.padding-left__small {
    padding-left: 56px;
}
.padding-left__big {
    padding-left: 256px;
}
</style>
