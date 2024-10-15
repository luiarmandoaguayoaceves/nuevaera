// document.addEventListener('DOMContentLoaded', () => {

//     let fotos = document.querySelector('#fotos'); // Contenedor principal de fotos
//     let url = '/imagenes'; // URL de la API o JSON donde están las imágenes

//     let mdCounter = 1; // Contador para las clases md:w-1/3, md:w-2/3, md:w-3/3
//     let xlCounter = 1; // Contador para las clases xl:w-1/4, xl:w-2/4, xl:w-3/4, xl:w-4/4

//     fetch(url)
//         .then(response => response.json()) // Procesar la respuesta como JSON
//         // .then(respuesta => {
//             // Iterar sobre la respuesta (asumiendo que es un array de nombres de imágenes)
//             respuesta.forEach(respuesta => {
//                 // Crear el div contenedor para cada imagen
//                 let foto = document.createElement('div');
                
//                 // Definir clases dinámicas según los contadores
//                 let mdClass = `md:w-${mdCounter}/3`;
//                 let xlClass = `xl:w-${xlCounter}/4`;

//                 // Aplicar las clases
//                 foto.classList.add('w-full', mdClass, xlClass, 'p-6', 'flex', 'flex-col');

//                 // Insertar la estructura HTML dentro del div
//                 foto.innerHTML = `
//                     <img class="hover:grow hover:shadow-lg" src="img/galeria/${respuesta.nombre}.jpeg" alt="Imagen de galería">
//                     <div class="pt-3 flex items-center justify-between">
//                         <p class="">Mod:
//                             <span class="pt-1 text-gray-900"> 1872 </span>
//                         </p>
//                     </div>
//                 `;
                
//                 // Agregar el nuevo div al contenedor principal de fotos
//                 fotos.appendChild(foto);

//                 // Incrementar los contadores y reiniciarlos si es necesario
//                 mdCounter = mdCounter < 3 ? mdCounter + 1 : 1; // md se reinicia después de 3
//                 xlCounter = xlCounter < 4 ? xlCounter + 1 : 1; // xl se reinicia después de 4
//             });
//         })
//         .catch(error => console.error('Error al cargar las imágenes:', error)); // Manejo de errores

// });
