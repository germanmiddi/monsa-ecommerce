export const useBuildImg = (imagen) => {
    // Asegura que la ruta de la imagen comience siempre con una barra '/'
    const imagePath = imagen.startsWith('/') ? imagen : '/' + imagen;
    const img = `https://www.monsa-srl.com.ar/pedidosweb${imagePath}`;
    return img;
  
}