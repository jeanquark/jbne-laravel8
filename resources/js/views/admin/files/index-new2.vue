<template>
    <div>
        <h1>Files</h1>
        directories: {{ directories }}<br /><br />
        files: {{ files }}<br /><br />
        directoriesObject: {{ directoriesObject }}<br /><br />
        directoriesObjectById: {{ directoriesObjectById }}<br /><br />
        directoriesArray: {{ directoriesArray }}<br /><br />
        directoriesArray2: {{ directoriesArray2 }}<br /><br />
        filesObject: {{ filesObject }}<br /><br />
        filesArray: {{ filesArray }}<br /><br />
        idsObject: {{ idsObject }}<br /><br />
        items: {{ items }}<br /><br />
        rootFolder: {{ rootFolder }}<br /><br />
        directoriesObject:<br />
        <div v-for="(item, index) in directoriesObject" :key="index">{{ index }} --- {{ item }} <br /><br /></div>
        <br /><br />
        currentFolder: {{ currentFolder }}<br />
        opened: {{ opened }}<br />
        openedId: {{ openedId }}<br />
        difference: {{ difference }}<br />
        differenceId: {{ differenceId }}<br />
        goTo: {{ goTo }}<br />
        <v-row no-gutters>
            <v-col cols="4" style="border: 1px solid orange">
                <v-treeview shaped hoverable open-on-click return-object :items="items" item-key="name" @update:open="updateOpen">
                    <template v-slot:label="{ item }">
                        <span v-if="item.file" class="file" @click="download(item)">
                            {{ item.name }}
                        </span>
                        <span style="border: 1px dashed green" v-else>
                            {{ item.name }}
                        </span>
                    </template>
                </v-treeview>
            </v-col>
            <v-col cols="8" style="border: 1px solid purple">
                currentFolder: {{ currentFolder }}<br />
                <v-btn small @click="createFolder">Create folder</v-btn>
                <v-btn small @click="deleteFolder">Delete folder</v-btn>
                <v-btn small @click="navigateBack" v-if="currentFolder">&larr; Back</v-btn>
                <span v-if="currentFolder">Content of {{ currentFolder['name'] }}:</span>
                <span v-else>Content of root</span>
                <div class="item" v-if="currentFolder">
                    <div style="border: 1px solid red; margin: 10px" v-for="(item, index) in currentFolder.children" :key="index" @click="selectFolder(item)">{{ item }}</div>
                </div>
                <div class="item" v-else>
                    <div style="border: 1px dashed blue; margin: 10px" v-for="(item, index) in rootFolder" :key="index" @click="selectFolder(item)">{{ item }}</div>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import fileDownload from 'js-file-download'
export default {
    name: 'AdminFilesIndex',
    async created() {
        const { directories } = await this.$store.dispatch('folders/fetchFolders')
        const { files } = await this.$store.dispatch('files/fetchFiles')
        this.directories = directories
        this.files = files

        let separator
        let index = 0
        let id
        let parentId
        // Loop through directories
        for (let i = 0; i < this.directories.length; i++) {
            // console.log('directories[i]: ', this.directories[i])
            separator = this.directories[i].split('/')
            // console.log('separator: ', separator)
            id = i + 1
            if (separator[separator.length - 2]) {
                if (separator[separator.length - 3]) {
                    parentId = this.directoriesObject[`${separator[separator.length - 3]}_${separator[separator.length - 2]}`]['id']
                } else {
                    parentId = this.directoriesObject[`${separator[separator.length - 2]}`]['id']
                }
                // console.log('childen: ', children)
                this.directoriesObject[`${separator[separator.length - 2]}_${separator[separator.length - 1]}`] = {
                    name: separator[separator.length - 1],
                    id,
                    parentId,
                    children: [],
                }

                this.directoriesObjectById[`${parentId}_${id}`] = {
                    name: separator[separator.length - 1],
                    id,
                    parentId,
                    children: [],
                }
                index++

                if (separator[separator.length - 3]) {
                    // By name
                    this.directoriesObject[`${separator[separator.length - 3]}_${separator[separator.length - 2]}`]['children'].push(separator[separator.length - 1])

                    // By id
                    const grandParentId = this.directoriesObject[`${separator[separator.length - 3]}_${separator[separator.length - 2]}`]['parentId']
                    this.directoriesObjectById[`${grandParentId}_${parentId}`]['children'].push(separator[separator.length - 1])
                } else {
                    // By name
                    this.directoriesObject[`${separator[separator.length - 2]}`]['children'].push(separator[separator.length - 1])

                    // By id
                    const grandParentId = this.directoriesObject[`${separator[separator.length - 2]}`]['parentId']
                    this.directoriesObjectById[`${grandParentId}_${parentId}`]['children'].push(separator[separator.length - 1])
                }
            } else {
                parentId = 0
                this.directoriesObject[`${separator[separator.length - 1]}`] = {
                    name: separator[separator.length - 1],
                    id,
                    parentId,
                    children: [],
                }
                this.directoriesObjectById[`${parentId}_${id}`] = {
                    name: separator[separator.length - 1],
                    id,
                    parentId,
                    children: [],
                }
            }

            this.directoriesArray.push({
                name: separator[separator.length - 1],
                id,
                parentId,
            })
        }

        // Loop through files
        for (let i = 0; i < this.files.length; i++) {
            separator = this.files[i].split('/')
            console.log('separator: ', separator)
            this.filesArray.push({
                name: separator[separator.length - 1],
                path: this.files[i]
            })
            this.filesObject[this.files[i]] = {
                name: separator[separator.length - 1],
                path: this.files[i]
            }

            if (separator[separator.length - 2]) {
                if (separator[separator.length - 3]) {
                    parentId = this.directoriesObject[`${separator[separator.length - 3]}_${separator[separator.length - 2]}`]['id']
                    // By name
                    this.directoriesObject[`${separator[separator.length - 3]}_${separator[separator.length - 2]}`]['children'].push(separator[separator.length - 1])

                    // By id
                    const grandParentId = this.directoriesObject[`${separator[separator.length - 3]}_${separator[separator.length - 2]}`]['parentId']
                    this.directoriesObjectById[`${grandParentId}_${parentId}`]['children'].push(separator[separator.length - 1])

                    // Array
                    this.directoriesArray.push({
                        name: separator[separator.length - 1],
                        id: index + 1,
                        parentId: this.directoriesObject[`${separator[separator.length - 3]}_${separator[separator.length - 2]}`]['id'],
                        path: this.files[i],
                        file: true,
                    })
                } else {
                    parentId = this.directoriesObject[`${separator[separator.length - 2]}`]['id']
                    // By name
                    this.directoriesObject[`${separator[separator.length - 2]}`]['children'].push(separator[separator.length - 1])

                    // By id
                    const grandParentId = this.directoriesObject[`${separator[separator.length - 2]}`]['parentId']
                    this.directoriesObjectById[`${grandParentId}_${parentId}`]['children'].push(separator[separator.length - 1])

                    // Array
                    this.directoriesArray.push({
                        name: separator[separator.length - 1],
                        id: index + 1,
                        parentId: this.directoriesObject[`${separator[separator.length - 2]}`]['id'],
                        path: this.files[i],
                        file: true,
                    })
                }
            } else {
                parentId = 0
                // By name
                this.directoriesObject[`${separator[separator.length - 1]}`] = {
                    name: separator[separator.length - 1],
                    id,
                    parentId,
                }

                // By id
                this.directoriesObjectById[`${parentId}_${id}`] = {
                    name: separator[separator.length - 1],
                    id,
                    parentId,
                }

                // Array
                this.directoriesArray.push({
                    name: separator[separator.length - 1],
                    id: index + 1,
                    parentId: 0,
                    path: this.files[i],
                    file: true,
                })
            }
            index++
        }

        // Create nested array
        this.items = this.listToTree(this.directoriesArray)
    },
    // mounted() {
    //     this.items = this.listToTree(this.directoriesArray)
    // },
    data() {
        return {
            directories: [],
            files: [],
            directoriesObject: {},
            directoriesObjectById: {},
            directoriesArray: [],
            directoriesArray2: [],
            filesObject: {},
            filesArray: [],
            idsObject: {},
            currentFolder: null,
            items: [],
            active: [],
            opened: [],
            openedId: [],
            selectedItem: null,
            difference: null,
            differenceId: null,
            goTo: null,
        }
    },
    computed: {
        rootFolder() {
            return this.items.map((a) => a.name)
        },
    },
    methods: {
        updateOpen(items) {
            console.log('updateOpen items: ', items)
            console.log('openedId: ', this.openedId)
            if (items && items.length > 0) {
                const { parentId, id } = items[items.length - 1]
                this.currentFolder = this.directoriesObjectById[`${parentId}_${id}`]
            }
            if (this.opened.length > 0) {
                this.difference = this.opened.filter((x) => !items.map((item) => item.name).includes(x))[0]

                this.differenceId = this.openedId.filter(function (obj) {
                    return !items.some(function (obj2) {
                        return obj.name == obj2.name
                    })
                })
            }
            this.opened = items.map((item) => item.name)
            this.openedId = items.map(({ name, id, parentId }) => ({ name, id, parentId }))
            if (this.differenceId && this.differenceId.length > 0) {
                const { parentId } = this.differenceId[0]
                if (parentId == 0) {
                    this.currentFolder = null
                }
                this.difference = null
                this.differenceId = null
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
            try {
                console.log('selectFolder: ', item)
                return
                const isFile = this.filesObject[item] ? true : false
                const { parentId, id } = this.filesObject[item]
                console.log('isFile: ', isFile)
                if (isFile) {
                    console.log('Download file')
                    this.download(this.filesObject[item])
                } else {
                    // this.currentFolder = this.directoriesObject[item]
                    // this.currentFolder = this.directoriesObjectById[`${parentId}_${id}`]
                }
            } catch (error) {
                console.log('error: ', error)
            }
        },
        navigateBack() {
            try {
                if (this.currentFolder.parentId == 0) {
                    this.currentFolder = null
                } else {
                    const parentFolder = this.directoriesArray.find((x) => x.id == this.currentFolder.parentId)
                    console.log('parentFolder: ', parentFolder)
                    this.currentFolder = this.directoriesObject[parentFolder['name']]
                }
            } catch (error) {
                console.log('error: ', error)
            }
        },
        async download(file) {
            try {
                console.log('download file: ', file)
                const filePath = encodeURI(file.path)
                const data = await this.$store.dispatch('files/fetchFile', { filePath })
                fileDownload(data.data, file.name)
            } catch (error) {
                console.log('error: ', error)
                alert('Sorry, an error occured when trying to download file.')
            }
        },
        async createFolder() {
            try {
                await this.$store.dispatch('folders/createFolder', { path: '/new folder/new folder2' })
                alert('Folder created successfully!')
            } catch (error) {
                console.log('error: ', error)
            }
        },
        async deleteFolder() {
            try {
                await this.$store.dispatch('folders/deleteFolder', { path: '/new folder/new folder3' })
                alert('Folder deleted successfully!')
            } catch (error) {
                console.log('error: ', error)
                console.log('error.response: ', error.response)
                console.log('error.response.data: ', error.response.data)
            }
        },
    },
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
