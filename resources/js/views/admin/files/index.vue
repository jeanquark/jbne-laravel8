<template>
    <div>
        <h1>Files</h1>
        folders: {{ folders }}<br /><br />
        filePaths: {{ filePaths }}<br /><br />
        files: {{ files }}<br /><br />
        tree: {{ tree }}<br /><br />
        items: {{ items }}<br /><br />
        array: {{ array }}<br /><br />
        <v-treeview v-model="tree" :open="open" :items="items" item-key="name" activatable open-on-click>
            <template v-slot:prepend="{ item, open }">
                <v-icon v-if="!item.file">
                    {{ open ? 'mdi-folder-open' : 'mdi-folder' }}
                </v-icon>
                <v-icon v-else>
                    {{ icons[item.file] }}
                </v-icon>
            </template>
        </v-treeview>
        <!-- <v-treeview v-model="tree" :open="open" :items="items" activatable item-key="name" open-on-click>
            <template v-slot:prepend="{ item, open }">
                <v-icon v-if="!item.file">
                    {{ open ? 'mdi-folder-open' : 'mdi-folder' }}
                </v-icon>
                <v-icon v-else>
                    {{ files[item.file] }}
                </v-icon>
            </template>
        </v-treeview> -->
    </div>
</template>

<script>
export default {
    name: 'AdminFilesIndex',
    async created() {
        const folders = await this.$store.dispatch('files/fetchFiles')
        console.log('folders: ', folders)
        this.folders = folders

        // const folders = data[0].split('/')
        // console.log('folders: ', folders)

        for (let i = 0; i < folders.length; i++) {
            // console.log('data[i]: ', data[i])
            const directories = folders[i].split('/')
            console.log('directories: ', directories)
            // console.log(`create directory: ${directories[directories.length - 1]} at position ${i}`)
            
            // if (filesAndFolders[0].indexOf('.') != -1) {
            //     this.items.push({
            //         name: filesAndFolders[0],
            //         file: 'pdf',
            //     })
            // } else {
            //     if (!this.items.find(item => item.name == filesAndFolders[0])) {
            //         this.items.push({
            //             name: filesAndFolders[0],
            //             children: [],
            //         })
            //     }
            // }
            for (let k = directories.length - 1; k >= 0; k--) {
                console.log(`k ${k}, i ${i}`)
                this.items.push({
                    
                })
            }
            for (let j = 0; j < directories.length; j++) {
                // console.log(`directories[j]: ${directories[j]} i${i} j${j}`)
                // this.array[i] = 'abc'
                // this.array[i][j] = 'def'
                // this.items[j] = {
                //     name: 'abc',
                //     children: []
                // }
                // console.log('directories.length: ', directories.length)
                // if (directories.length == 1) {
                //     this.items.push({
                //         name: directories[0],
                //         children: [],
                //     })
                // }
                // if (directories.length == 2) {
                //     console.log(directories[0])
                //     // if (!this.items[1]) {
                //         this.items[1]['children'].push({
                //             name: directories[directories.length - 1],
                //             children: [],
                //         })
                //     // }
                // }
                // console.log(`i${i}, j:${j}`)
                // console.log(`create directory: ${directories[directories.length - 1]} at position ${j}`)

                // if (!this.items.find(item => item.name == directories[0])) {
                //     this.items.push({
                //         name: directories[0],
                //         children: []
                //     })
                // }
                // if (filesAndFolders[j].indexOf('.') == -1) {
                //     console.log(`create folder "${filesAndFolders[j]}" at i${i} j${j}`)
                //     if (j == 0 && !this.items.find(item => item.name == filesAndFolders[j])) {
                //         this.items.push({
                //             name: filesAndFolders[j],
                //             children: []
                //         })
                //     }
                //     if (j == 1 && this.items[i] && this.items[i]['children'] && !this.items[i]['children'].find(item => item.name == filesAndFolders[j])) {
                //         this.items[i]['children'].push({
                //             name: filesAndFolders[j],
                //             children: []
                //         })
                //     }
                //     if (j == 2 && this.items[i] && this.items[i]['children'] && this.items[i]['children'][j] && this.items[i]['children'][j]['children'] && !this.items[i]['children'][j]['children'].find(item => item.name == filesAndFolders[j])) {
                //         this.items[i]['children'][j]['children'].push({
                //             name: filesAndFolders[j],
                //             children: []
                //         })
                //     }
                // }
                // console.log('folders[j]: ', folders[j])
                // console.log('i: ', i)
                // console.log('j: ', j)
                // this.items[i]['children'][j] = {}
                // console.log('folders[j]: ', folders[j])
                // if (!this.items[0]) {
                //     this.items.push({})
                // }
                // this.items[i]['children'].push({
                //     name: 'abc.pdf',
                //     file: 'pdf',
                //     children: []
                // })
                if (directories[j].indexOf('.') != -1) {
                    // console.log(`${folders[j]} is a file i: ${i}, j: ${j}`)
                    // this.items.push({
                    //     name: folders[j]
                    // })
                    // this.items[i]['children'].push({
                    //     name: 'abc.pdf',
                    //     file: 'pdf',
                    //     children: [],
                    // })
                    // this.items[i]['children'].push({
                    //     name: folders[j],
                    //     file: 'pdf'
                    // })
                } else {
                    // console.log(`${folders[j]} is a folder i: ${i}, j: ${j}`)
                    // console.log('items[i]: ', this.items[i])
                    // if (this.items[i] && this.items[i]['children']) {
                    //     this.items[i]['children'].push({
                    //         name: folders[j],
                    //         children: [],
                    //     })
                    // }
                    // if (!this.items[i]) {
                    //     this.items.push({
                    //         children: []
                    //     })
                    // }
                    // this.items.push({
                    //     name: folders[j],
                    //     children: [],
                    // })
                    // this.items[i]['children'][j] = {
                    //     name: folders[j]
                    // }
                    // this.items[i]['children'][j] = {
                    //     name: folders[j]
                    // }
                }
                // this.items.push({
                //     name: data[i][j]
                // })
            }
            // for (let j = 0; j < data[i].length; j++) {
            //     this.items[i].push({
            //         children: {
            //             name: data[i][j]
            //         }
            //     })
            // }
            // this.items.push({
            //     name: data[i]
            // })
        }

        this.items2.push({
            name: 'public',
            children: [
                {
                    name: 'favicon.ico',
                    file: 'png',
                },
            ],
        })
    },
    data() {
        return {
            array: [],
            data: null,
            filePaths: null,
            folders: null,
            items: [],
            items2: [
                {
                    name: '.git',
                },
                {
                    name: 'public',
                    children: [
                        {
                            name: 'static',
                            children: [
                                {
                                    name: 'logo.png',
                                    file: 'png',
                                },
                            ],
                        },
                        {
                            name: 'favicon.ico',
                            file: 'png',
                        },
                    ],
                },
            ],
            open: [],
            tree: [],
            icons: {
                html: 'mdi-language-html5',
                js: 'mdi-nodejs',
                json: 'mdi-json',
                md: 'mdi-markdown',
                pdf: 'mdi-file-pdf',
                png: 'mdi-file-image',
                txt: 'mdi-file-document-outline',
                xls: 'mdi-file-excel',
            },
            // open: ['public'],
            // files: {
            //     html: 'mdi-language-html5',
            //     js: 'mdi-nodejs',
            //     json: 'mdi-json',
            //     md: 'mdi-markdown',
            //     pdf: 'mdi-file-pdf',
            //     png: 'mdi-file-image',
            //     txt: 'mdi-file-document-outline',
            //     xls: 'mdi-file-excel',
            // },
            // tree: [],
            // items: [
            //     {
            //         name: '.git',
            //     },
            //     {
            //         name: 'node_modules',
            //     },
            //     {
            //         name: 'public',
            //         children: [
            //             {
            //                 name: 'static',
            //                 children: [
            //                     {
            //                         name: 'logo.png',
            //                         file: 'png',
            //                     },
            //                 ],
            //             },
            //             {
            //                 name: 'favicon.ico',
            //                 file: 'png',
            //             },
            //             {
            //                 name: 'index.html',
            //                 file: 'html',
            //             },
            //         ],
            //     },
            //     {
            //         name: '.gitignore',
            //         file: 'txt',
            //     },
            //     {
            //         name: 'babel.config.js',
            //         file: 'js',
            //     },
            //     {
            //         name: 'package.json',
            //         file: 'json',
            //     },
            //     {
            //         name: 'README.md',
            //         file: 'md',
            //     },
            //     {
            //         name: 'vue.config.js',
            //         file: 'js',
            //     },
            //     {
            //         name: 'yarn.lock',
            //         file: 'txt',
            //     },
            // ],
        }
    },
    computed: {
        files() {
            return this.$store.getters['files/files']
        },
    },
}
</script>

<style scoped>
</style>