<template>
    <div>
        <h2>Permanences2</h2>
        date: {{ date }}<br /><br />
        dates: {{ dates }}<br /><br />

        <v-date-picker
            :first-day-of-week="1"
            :show-week="true"
            :multiple="true"
            @click:date="selectDate"
            v-model="dates"
        ></v-date-picker>
    </div>
</template>

<script>
import moment from "moment";
export default {
    name: "permanences",
    data() {
        return {
            date: "",
            dates: []
        };
    },
    methods: {
        selectDate(day) {
            console.log("selectDate: ", day);
            const dayOfWeek = new Date(day).getDay();
            console.log("day: ", day);
            console.log("dayOfWeek: ", dayOfWeek);
            const select = this.dates.includes(day);
            console.log("select: ", select);
            switch (dayOfWeek) {
                case 1:
                    console.log("case 1");
                    if (select) {
                        for (let i = 0; i < 0 + 7; i++) {
                            this.dates.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                    } else {
                        let values = [];
                        for (let i = 0; i < 0 + 7; i++) {
                            values.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                        console.log("values: ", values);
                        this.dates = this.dates.filter(
                            item => !values.includes(item)
                        );
                    }
                    break;
                case 2:
                    console.log("case 2");
                    if (select) {
                        for (let i = -1; i < -1 + 7; i++) {
                            this.dates.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                    } else {
                        let values = [];
                        for (let i = -1; i < -1 + 7; i++) {
                            values.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                        console.log("values: ", values);
                        this.dates = this.dates.filter(
                            item => !values.includes(item)
                        );
                    }
                    break;
                case 3:
                    console.log("case 3");
                    if (select) {
                        for (let i = -2; i < -2 + 7; i++) {
                            this.dates.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                    } else {
                        let values = []
                        for (let i = -2; i < -2 + 7; i++) {
                            values.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                        console.log('values: ', values)
                        this.dates = this.dates.filter(item => !values.includes(item));
                    }
                    break;
                case 4:
                    console.log('case 4')
                    if (select) {
                        for (let i = -3; i < -3 + 7; i++) {
                            this.dates.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                    } else {
                        let values = []
                        for (let i = -3; i < -3 + 7; i++) {
                            values.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                        console.log('values: ', values)
                        this.dates = this.dates.filter(item => !values.includes(item));
                    }
                    break;
                case 5:
                    console.log('case 5')
                    if (select) {
                        for (let i = -4; i < -4 + 7; i++) {
                            this.dates.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                    } else {
                        let values = []
                        for (let i = -4; i < -4 + 7; i++) {
                            values.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                        console.log('values: ', values)
                        this.dates = this.dates.filter(item => !values.includes(item));
                    }
                    break;
                case 6:
                    console.log('case 6')
                    if (select) {
                        for (let i = -5; i < -5 + 7; i++) {
                            this.dates.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                    } else {
                        let values = []
                        for (let i = -5; i < -5 + 7; i++) {
                            values.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                        console.log('values: ', values)
                        this.dates = this.dates.filter(item => !values.includes(item));
                    }
                    break;
                case 0:
                    console.log('case 0')
                    if (select) {
                        for (let i = -6; i < -6 + 7; i++) {
                            this.dates.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                    } else {
                        let values = []
                        for (let i = -6; i < -6 + 7; i++) {
                            values.push(
                                moment(day)
                                    .add(i, "days")
                                    .format("YYYY-MM-DD")
                            );
                        }
                        console.log('values: ', values)
                        this.dates = this.dates.filter(item => !values.includes(item));
                    }
                    break;
                default:
                    console.log("default");
                    this.dates = [];
                    break;
            }
        }
    }
};
</script>

<style scoped></style>
