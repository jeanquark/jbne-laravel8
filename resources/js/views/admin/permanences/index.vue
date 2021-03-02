<template>
    <v-row no-gutters>
        <v-col cols="12">
            <h1>Permanences</h1>
            year: {{ year }}<br /><br />
            quarter: {{ quarter }}<br /><br />
            years: {{ years }}<br /><br />
            <!-- quarters: {{ quarters }}<br /><br /> -->
            <!-- permanences: {{ permanences }}<br /><br /> -->
            <!-- calendars: {{ calendars }}<br /><br /> -->
            <!-- headers: {{ headers }}<br /><br /> -->
            <!-- data: {{ data }}<br /><br /> -->
        </v-col>

        <br /><br />

        <v-col cols="12">
            <v-tabs color="primary" slider-color="yellow">
                <v-tab
                    v-for="i in years.length"
                    :key="i"
                    ripple
                    @click="switchYear(i - 1)"
                    >{{ years[i - 1] }}</v-tab
                >
                <v-tab-item v-for="n in years.length" :key="n">
                    <v-card flat>
                        <v-tabs color="secondary" slider-color="yellow">
                            <v-tab
                                v-for="j in quarters.length"
                                :key="j"
                                @click="switchQuarter(j - 1)"
                            >
                                Trimestre {{ quarters[j - 1] }}
                            </v-tab>
                            <!-- <v-tab-item v-for="j in quarters.length" :key="j">
                                <v-card flat>
                                    <v-card-text>nested {{ j }}</v-card-text>
                                </v-card>
                            </v-tab-item> -->
                        </v-tabs>
                    </v-card>
                </v-tab-item>
            </v-tabs>
            <v-data-table
                :headers="headers"
                :items="data"
                :hide-default-header="true"
                class="elevation-1"
            >
                <template v-slot:header="{ props }">
                    <thead>
                        <tr>
                            <th
                                class="text-center"
                                v-for="(head, index) in props.headers"
                                :key="index"
                            >
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">{{
                                            head.text.toUpperCase()
                                        }}</span>
                                    </template>
                                    <span>{{ head.tooltip }}</span>
                                </v-tooltip>
                            </th>
                            <th>
                                Total dispo
                            </th>
                            <th>
                                Total attr
                            </th>
                            <th>
                                Dernière modification
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                </template>

                <template v-slot:[`item`]="{ item, index }">
                    <tr style="" v-if="headers && headers.length">
                        <td>
                            {{ item.user.name }}
                        </td>
                        <td
                            class="text-center"
                            v-for="n in headers.length - 1"
                            :key="n"
                        >
                            <!-- <span v-if="item[`week${n}`]"> -->
                            <span>
                                <!-- n: {{ n }}<br /> -->
                                <!-- headers[n][value]: {{ headers[n]['value'] }}<br /> -->
                                <!-- index: {{ index }}<br /> -->
                                <!-- item: {{ item }}<br /> -->
                                <!-- item[week${n}]: {{ item[`week${n}`] }}<br /> -->
                                <!-- item[headers[n][value]]: {{ item[`${headers[n]['value']}`] }}<br /> -->
                                <!-- permId: {{ item[`week${n}`]['permanence_id'] }} -->
                                <v-icon
                                    color="success"
                                    @click="
                                        updateStatus({
                                            permanenceId:
                                                item[`${headers[n]['value']}`][
                                                    'permanence_id'
                                                ],
                                            week_nb_in_year:
                                                item[`${headers[n]['value']}`][
                                                    'week_nb_in_year'
                                                ],
                                            week_nb_in_month:
                                                item[`${headers[n]['value']}`][
                                                    'week_nb_in_month'
                                                ],
                                            action: 'remove_attr'
                                        })
                                    "
                                    v-if="
                                        item[`${headers[n]['value']}`] && item[`${headers[n]['value']}`]['dispo'] &&
                                            item[`${headers[n]['value']}`]['attr']
                                    "
                                >
                                    mdi-checkbox-marked
                                </v-icon>
                                <v-icon
                                    @click="
                                        updateStatus({
                                            permanenceId:
                                                item[`${headers[n]['value']}`][
                                                    'permanence_id'
                                                ],
                                            week_nb_in_year:
                                                item[`${headers[n]['value']}`][
                                                    'week_nb_in_year'
                                                ],
                                            week_nb_in_month:
                                                item[`${headers[n]['value']}`][
                                                    'week_nb_in_month'
                                                ],
                                            action: 'remove_dispo'
                                        })
                                    "
                                    v-else-if="item[`${headers[n]['value']}`] && item[`${headers[n]['value']}`][`dispo`]"
                                >
                                    mdi-checkbox-blank-outline
                                </v-icon>
                                <v-icon
                                    @click="
                                        updateStatus({
                                            permanenceId:
                                                item[`${headers[n]['value']}`][
                                                    'permanence_id'
                                                ],
                                            week_nb_in_year:
                                                item[`${headers[n]['value']}`][
                                                    'week_nb_in_year'
                                                ],
                                            week_nb_in_month:
                                                item[`${headers[n]['value']}`][
                                                    'week_nb_in_month'
                                                ],
                                            action: 'add_dispo'
                                        })
                                    "
                                    color="error"
                                    v-else
                                >
                                    mdi-close-circle-outline
                                </v-icon>
                            </span>
                        </td>
                        <td class="text-center">
                            {{ calcDispoByUser(item, index) }}
                        </td>
                        <td class="text-center">
                            {{ calcAttrByUser(item, index) }}
                        </td>
                        <td>
                            <span>{{ item.updated_at }}</span>
                        </td>
                        <td style="white-space: nowrap;">
                            <v-btn x-small color="success">Montrer</v-btn>
                            <v-btn x-small color="info">Editer</v-btn>
                            <v-btn x-small color="error">Supprimer</v-btn>
                        </td>
                    </tr>
                </template>
                <template v-slot:[`body.append`]="{ headers }">
                    <tr v-if="headers && headers.length">
                        <td colspan="1">Total attributions</td>
                        <td
                            class="text-center"
                            v-for="n in headers.length - 1"
                            :key="n"
                        >
                            <v-chip
                                small
                                color="success"
                                v-if="calcAttrByWeek(headers[n]) === 4"
                            >
                                {{ calcAttrByWeek(headers[n]) }}
                            </v-chip>
                            <v-chip small v-else>
                                {{ calcAttrByWeek(headers[n]) }}
                            </v-chip>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "AdminPermanencesIndex",
    async created() {
        try {
            await this.$store.dispatch("calendars/fetchCalendars", {
                year: this.year,
                quarter: this.quarter
            });
            await this.$store.dispatch("permanences/fetchPermanences", {
                year: this.year,
                quarter: this.quarter
            });
        } catch (error) {
            console.log("error: ", error);
        }
    },
    data() {
        return {
            // headers: [],
            year: 2020,
            quarter: 1,
            // active: "0",
            // nestedActive: ["0", "0", "0"],
            years: [2020, 2021],
            // quarters: ['Semestre I', 'Semestre II', 'Semestre III', 'Semestre IV'],
            quarters: [1, 2, 3, 4],
            // selectedYear: null,
            // yearTab: null
        };
    },
    computed: {
        calendars() {
            try {
                console.log(
                    "calendars: year quarter: ",
                    this.year,
                    this.quarter
                );
                return this.$store.getters["calendars/calendars"][this.year][
                    this.quarter
                ];
            } catch (error) {
                return {};
            }
        },
        permanences() {
            try {
                return this.$store.getters["permanences/permanences"][
                    this.year
                ][this.quarter];
            } catch (error) {
                return {};
            }
        },
        headers() {
            let headers = [];
            headers.push({ text: "Avocat", value: "user.name" });
            if (this.calendars && this.calendars.length) {
                for (let i = 0; i < this.calendars.length; i++) {
                    for (let j = 1; j <= 5; j++) {
                        if (this.calendars[i][`week${j}_nb`]) {
                            headers.push({
                                text: "S" + this.calendars[i][`week${j}_nb`],
                                value: `week${
                                    this.calendars[i][`week${j}_nb`]
                                }`,
                                tooltip: this.calendars[i][`week${j}`]
                            });
                        }
                    }
                }
            }
            return headers;
        },
        data() {
            let object = {};
            if (this.permanences && this.permanences.length) {
                for (let i = 0; i < this.permanences.length; i++) {
                    if (!object[this.permanences[i]["user_id"]]) {
                        object[this.permanences[i]["user_id"]] = {};
                        object[this.permanences[i]["user_id"]][
                            "user"
                        ] = this.permanences[i]["user"];
                    }
                    (object[this.permanences[i]["user_id"]][`week${this.permanences[i]["week1_nb"]}`] = {
                    // (object[this.permanences[i]["user_id"]]['week1'] = {
                        permanence_id: this.permanences[i]["id"],
                        week_nb_in_year: this.permanences[i]["week1_nb"],
                        week_nb_in_month: 1,
                        dispo: this.permanences[i]["week1_dispo"],
                        attr: this.permanences[i]["week1_attr"]
                    }),
                        (object[this.permanences[i]["user_id"]][`week${this.permanences[i]["week2_nb"]}`] = {
                            permanence_id: this.permanences[i]["id"],
                            week_nb_in_year: this.permanences[i]["week2_nb"],
                            week_nb_in_month: 2,
                            dispo: this.permanences[i]["week2_dispo"],
                            attr: this.permanences[i]["week2_attr"]
                        }),
                        (object[this.permanences[i]["user_id"]][`week${this.permanences[i]["week3_nb"]}`] = {
                            permanence_id: this.permanences[i]["id"],
                            week_nb_in_year: this.permanences[i]["week3_nb"],
                            week_nb_in_month: 3,
                            dispo: this.permanences[i]["week3_dispo"],
                            attr: this.permanences[i]["week3_attr"]
                        }),
                        (object[this.permanences[i]["user_id"]][`week${this.permanences[i]["week4_nb"]}`] = {
                            permanence_id: this.permanences[i]["id"],
                            week_nb_in_year: this.permanences[i]["week4_nb"],
                            week_nb_in_month: 4,
                            dispo: this.permanences[i]["week4_dispo"],
                            attr: this.permanences[i]["week4_attr"]
                        });
                    if (this.permanences[i]["week5_nb"]) {
                        object[this.permanences[i]["user_id"]][`week${this.permanences[i]["week5_nb"]}`] = {
                            permanence_id: this.permanences[i]["id"],
                            week_nb_in_year: this.permanences[i]["week5_nb"],
                            week_nb_in_month: 5,
                            dispo: this.permanences[i]["week5_dispo"],
                            attr: this.permanences[i]["week5_attr"]
                        };
                    }
                    // Display last updated row in the quarter for a particular user
                    if (
                        !object[this.permanences[i]["user_id"]]["updated_at"] ||
                        object[this.permanences[i]["user_id"]]["updated_at"] <
                            this.permanences[i]["updated_at"]
                    ) {
                        object[this.permanences[i]["user_id"]][
                            "updated_at"
                        ] = this.permanences[i]["updated_at"];
                    }
                }
            }
            console.log("object: ", object);
            return Object.keys(object).map(k => object[k]);
        }
    },
    methods: {
        async updateStatus(data) {
            try {
                console.log("updateStatus: ", data);
                // return
                const {
                    permanenceId,
                    week_nb_in_year,
                    week_nb_in_month,
                    action
                } = data;
                let updatedPermanence = {};
                switch (action) {
                    case "remove_attr":
                        updatedPermanence[`week${week_nb_in_month}_dispo`] = 1;
                        updatedPermanence[`week${week_nb_in_month}_attr`] = 0;
                        break;
                    case "remove_dispo":
                        updatedPermanence[`week${week_nb_in_month}_dispo`] = 0;
                        updatedPermanence[`week${week_nb_in_month}_attr`] = 0;
                        break;
                    case "add_dispo":
                        updatedPermanence[`week${week_nb_in_month}_dispo`] = 1;
                        updatedPermanence[`week${week_nb_in_month}_attr`] = 1;
                        break;
                }
                console.log("updatedPermanence: ", updatedPermanence);
                // return;

                await this.$store.dispatch("permanences/updatePermanence", {
                    year: this.year,
                    quarter: this.quarter,
                    permanenceId,
                    updatedPermanence
                });
            } catch (error) {
                console.log("error");
            }
        },
        calcAttrByWeek(item) {
            try {
                // console.log('calcAttrByWeek: ', item)
                // return 0
                return this.data
                    .map(permanence => permanence[item.value])
                    .reduce((a, b) => a + (parseInt(b["attr"]) || 0), 0);
            } catch (error) {
                console.log('error: ', error)
                return "NaN";
            }
        },
        calcAttrByUser(item, index) {
            try {
                let sum = 0;
                Object.entries(this.data[index]).forEach(([key, value]) => {
                    sum += parseInt(value["attr"]) || 0;
                });
                return sum;
            } catch (error) {
                return "NaN";
            }
        },
        calcDispoByUser(item, index) {
            try {
                let sum = 0;
                Object.entries(this.data[index]).forEach(([key, value]) => {
                    sum += parseInt(value["dispo"]) || 0;
                });
                return sum;
            } catch (error) {
                return "NaN";
            }
        },
        async switchYear(index) {
            try {
                console.log("switchYear: ", index);
                this.year = this.years[index];
                if (!this.calendars[this.year]) {
                    await this.$store.dispatch("calendars/fetchCalendars", {
                        year: this.year,
                        quarter: this.quarter
                    });
                }
                if (!this.permanences[this.year]) {
                    await this.$store.dispatch("permanences/fetchPermanences", {
                        year: this.year,
                        quarter: this.quarter
                    });
                }
            } catch (error) {
                console.log("error: ", error);
            }
        },
        async switchQuarter(index) {
            try {
                console.log("switchQuarter: ", index);
                // this.year = this.years[index];
                this.quarter = this.quarters[index];
                // if (!this.calendars[this.year] && !this.calendars[this.year][this.quarter]) {
                await this.$store.dispatch("calendars/fetchCalendars", {
                    year: this.year,
                    quarter: this.quarter
                });
                // }
                // if (!this.permanences[this.year] && !this.permanences[this.year][this.quarter]) {
                await this.$store.dispatch("permanences/fetchPermanences", {
                    year: this.year,
                    quarter: this.quarter
                });
                // }
            } catch (error) {
                console.log("error: ", error);
            }
        }
    }
};
</script>

<style scoped></style>
