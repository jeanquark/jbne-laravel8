<template>
    <div>
        <h1>Files</h1>
        directories: {{ directories }}<br /><br />
        files: {{ files }}<br /><br />
        directoriesObject: {{ directoriesObject }}<br /><br />
        directoriesArray: {{ directoriesArray }}<br /><br />
        items2: {{ items2 }}<br /><br />
        rootFolder: {{ rootFolder }}<br /><br />
        directoriesObject:<br />
        <div v-for="(item, index) in directoriesObject" :key="index">{{ index }} ---> {{ item }} <br /><br /></div>
        <br /><br />
        currentFolder: {{ currentFolder }}<br />
        opened: {{ opened }}<br />
        difference: {{ difference }}<br />
        goTo: {{ goTo }}<br />
        <v-row no-gutters>
            <v-col cols="4" style="border: 1px solid orange;">
                <v-treeview shaped hoverable open-on-click return-object :items="items2" item-key="name" @update:open="updateOpen">
                    <template v-slot:label="{ item }">
                        <span v-if="item.file" class="file" @click="download(item)">
                            {{ item.name }}
                        </span>
                        <span style="border: 1px dashed green;" v-else>
                            {{ item.name }}
                        </span>
                    </template>
                </v-treeview>
            </v-col>
            <v-col cols="8" style="border: 1px solid purple;">
                <v-btn small @click="goBack" v-if="currentFolder">&larr; Back</v-btn>
                <span v-if="currentFolder">Content of {{ currentFolder['name'] }}:</span>
                <span v-else>Content of root</span>
                <div class="item" v-if="currentFolder">
                    <div style="border: 1px solid red; margin: 10px;" v-for="(item, index) in currentFolder.children" :key="index" @click="selectFolder(item)">item: {{ item }}</div>
                </div>
                <div class="item" v-else>
                    <div style="border: 1px dashed red; margin: 10px;" v-for="(item, index) in rootFolder" :key="index" @click="selectFolder(item)">item: {{ item }}</div>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    name: 'AdminFilesIndex',
    async created() {
        const data = await this.$store.dispatch('files/fetchFiles')
        // console.log("data: ", data);
        this.directories = data['directories']
        this.files = data['files']

        let separator
        let index2 = 0
        // Loop through directories
        for (let i = 0; i < this.directories.length; i++) {
            separator = this.directories[i].split('/')
            // console.log('separator: ', separator)
            if (!this.directoriesObject[separator[separator.length - 1]]) {
                this.directoriesObject[`${separator[separator.length - 1]}`] = {
                    name: separator[separator.length - 1],
                    id: i + 1,
                    parentId: this.directoriesObject[separator[separator.length - 2]] ? this.directoriesObject[separator[separator.length - 2]]['id'] : 0,
                    children: []
                }
                index2++
                this.directoriesArray.push({
                    name: separator[separator.length - 1],
                    id: i + 1,
                    parentId: this.directoriesObject[separator[separator.length - 2]] ? this.directoriesObject[separator[separator.length - 2]]['id'] : 0
                    // children: []
                })
            }
            if (separator[separator.length - 2]) {
                this.directoriesObject[separator[separator.length - 2]]['children'].push(separator[separator.length - 1])
            }
        }

        // Loop through files
        for (let i = 0; i < this.files.length; i++) {
            separator = this.files[i].split('/')
            if (separator[separator.length - 2]) {
                this.directoriesObject[separator[separator.length - 2]]['children'].push(separator[separator.length - 1])
                this.directoriesArray.push({
                    name: separator[separator.length - 1],
                    id: index2 + 1,
                    // parentId: this.directoriesObject[separator[separator.length - 1]]
                    parentId: this.directoriesObject[separator[separator.length - 2]]['id']
                })
                // index2++
            } else {
                this.directoriesObject[separator[separator.length - 1]] = {
                    name: separator[separator.length - 1],
                    id: index2 + 1,
                    parentId: 0
                }
                this.directoriesArray.push({
                    name: separator[separator.length - 1],
                    id: index2 + 1,
                    parentId: 0
                })
                // index2++
            }
            index2++
        }

        // Create nested array
        this.items2 = this.listToTree(this.directoriesArray)

        // for (let entry in this.directoriesObject) {
        //     console.log('entry: ', entry)
        //     if (this.directoriesObject[entry]['parentId'] == 0) {
        //         this.items2.push({
        //             id: this.directoriesObject[entry]['id'] ? this.directoriesObject[entry]['id'] : null,
        //             parentId: this.directoriesObject[entry]['parentId'],
        //             name: entry,
        //             children: []
        //         })
        //     } else {
        //         const abc = this.items2.find(item => item.id == this.directoriesObject[entry]['parentId'])
        //         console.log('abc: ', abc)
        //     }
        //     // abc['children'].push('abc')
        //     // this.items2.find(item => item.children.some(item => item.name === 'milk'));

        // }
    },
    mounted() {},
    data() {
        return {
            directories: [],
            files: [],
            directoriesObject: {},
            directoriesArray: [],
            currentFolder: null,
            // currentFolder: {
            //     children: []
            // },
            items: [
                {
                    id: 1,
                    name: 'Applications',
                    children: [
                        { id: 2, name: 'calendar.php' },
                        { id: 3, name: 'chrome.php' },
                        { id: 4, name: 'webstorm.php' }
                    ]
                },
                {
                    id: 5,
                    name: 'Documents',
                    children: [
                        {
                            id: 6,
                            name: 'Vuetify',
                            children: [
                                {
                                    id: 7,
                                    name: 'Src',
                                    children: [
                                        { id: 8, name: 'index.php' },
                                        { id: 9, name: 'bootstrap.php' }
                                    ]
                                }
                            ]
                        },
                        {
                            id: 10,
                            name: 'Material',
                            children: [
                                {
                                    id: 11,
                                    name: 'Src',
                                    children: [
                                        { id: 12, name: 'v-btn.php' },
                                        { id: 13, name: 'v-card.php' },
                                        { id: 14, name: 'v-window.php' }
                                    ]
                                }
                            ]
                        }
                    ]
                },
                {
                    id: 15,
                    name: 'Downloads',
                    children: [
                        { id: 16, name: 'october.pdf' },
                        { id: 17, name: 'november.pdf' },
                        { id: 18, name: 'tutorial.html' }
                    ]
                },
                {
                    id: 19,
                    name: 'Videos',
                    children: [
                        {
                            id: 20,
                            name: 'Tutorials',
                            children: [
                                { id: 21, name: 'basic-layouts.mp4' },
                                { id: 22, name: 'advanced-techniques.mp4' },
                                { id: 23, name: 'all-about-app.mp4' }
                            ]
                        },
                        { id: 24, name: 'intro.pdf' },
                        { id: 25, name: 'conference-introduction.pdf' }
                    ]
                }
            ],
            items2: [],
            active: [],
            opened: [],
            selectedItem: null,
            difference: null,
            goTo: null
        }
    },
    computed: {
        rootFolder() {
            return this.items2.map(a => a.name)
        }
    },
    methods: {
        updateOpen(items) {
            console.log('updateOpen items: ', items)
            // console.log('opened: ', this.opened)
            console.log('abc: ', items[items.length - 1])
            if (this.opened.length > 0) {
                this.difference = this.opened.filter(x => !items.map(item => item.name).includes(x))[0]
            }
            this.opened = items.map(item => item.name)
            if (this.difference) {
                // this.goTo = this.difference + ' parent'
                // this.currentFolder = this.directoriesObject[this.difference]
                const parentId = this.directoriesObject[this.difference]['parentId']
                console.log('parentId : ', parentId)
                if (parentId != 0) {
                    const parentFolder = this.directoriesArray.find(x => x.id == parentId)
                    this.goTo = parentFolder['name']
                    this.currentFolder = this.directoriesObject[this.goTo]
                } else {
                    this.goTo = null
                    this.currentFolder = null
                }
                console.log('goTo: ', this.goTo)
                this.difference = null
            } else {
                this.goTo = this.opened[this.opened.length - 1]
                this.currentFolder = this.directoriesObject[this.goTo]
            }
        },
        listToTree(list) {
            var map = {},
                node,
                roots = [],
                i

            for (i = 0; i < list.length; i += 1) {
                map[list[i].id] = i // initialize the map
                list[i].children = [] // initialize the children
            }

            for (i = 0; i < list.length; i += 1) {
                node = list[i]
                if (node.parentId !== 0) {
                    // if you have dangling branches check that map[node.parentId] exists
                    list[map[node.parentId]].children.push(node)
                } else {
                    roots.push(node)
                }
            }
            return roots
        },
        selectFolder(item) {
            console.log('selectFolder: ', item)
            this.currentFolder = this.directoriesObject[item]
        },
        goBack() {
            try {
                if (this.currentFolder.parentId == 0) {
                    this.currentFolder = null
                } else {
                    const parentFolder = this.directoriesArray.find(x => x.id == this.currentFolder.parentId)
                    console.log('parentFolder: ', parentFolder)
                    this.currentFolder = this.directoriesObject[parentFolder['name']]
                }
            } catch (error) {
                console.log('error: ', error)
            }
        }
    }
}
</script>

<style scoped>
.item {
    margin: 10px;
}
.item:hover {
    cursor: pointer;
}
.file:hover {
    color: blue;
}
</style>
