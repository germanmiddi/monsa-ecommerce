<template>
  <div class="carousel mx-auto justify-center"
       @touchstart="onDragStart"
       @touchmove="onDragMove"
       @touchend="onDragEnd"
       @mousedown="onDragStart"
       @mousemove="onDragMove"
       @mouseup="onDragEnd"
       @mouseleave="onDragEnd, resumeAutoplay"
       @mouseenter="pauseAutoplay"
       >
    <button @click="prevSlide">&lt;</button>
    <div class="carousel-container ">
      <div class="carousel-content" 
           :style="{ transform: `translateX(${-currentIndex * 260 + dragOffset}px)` }">

        <!-- <div v-for="product in displayItems" :key="product.id" class="product-slide">
          <div class="h-[550px] "> -->
            <!-- <div class="w-64" 
                style="background-image: ${firstImage(product.imagen)};"></div> -->
              <div class="w-60 h-32 "
                  :style="{ 'background-image': `url(${firstImage(product.imagen)})`, 
                            'background-size': 'cover' }"></div>
                            
            <!-- <img :src="firstImage(product.imagen)" :alt="product.name"> -->
            <!-- <h3 class="mt-3 mb-6 w-40 h-16" :title="product.modelo">{{ product.modelo }}</h3>            
            <div class="truncate">
              <p class="text-xl font-extrabold ">$ {{ product.precio }}</p>
            </div>
          </div>
        </div> -->
        <div v-for="product in displayItems" :key="product.id"  class="flex items-center justify-between border-b p-4">
          <img src="imagen.jpg" alt="Sistema 1" class="w-16 h-16 object-cover">
          <div class="flex-1 ml-4 truncate">
            <p class="text-lg font-semibold">Nombre del sistema</p>
          </div>
        </div>
      </div>
    </div>
    <button @click="nextSlide">&gt;</button>
  </div>
</template>

<script>
export default {
  props: {
    productItems: {
      type: Array,
      required: true
    },
    autoplayInterval: {
      type: Number,
      default: 3000
    }
  },
  name: 'ProductCarousel',
  data() {
    return {
      currentIndex: 0,
      slidesToShow: 5,
      dragStartX: 0,
      dragOffset: 0,
      isDragging: false,
      autoplayTimer: null,
      isAutoplayPaused: false
    }
  },
  computed: {
    displayItems() {
      return [...this.productItems, ...this.productItems.slice(0, this.slidesToShow)];
    }
  },
  mounted() {
    this.startAutoplay();
  },
  beforeDestroy() {
    this.stopAutoplay();
  },
  methods: {
    firstImage(imagen) {
      try {
        const imagenes = JSON.parse(imagen);
        return Array.isArray(imagenes) && imagenes.length > 0 ? `http://monsa-srl.com.ar/pedidosweb/${imagenes[0]}` : '';
      } catch (e) {
        console.error('Error parsing JSON', e);
        return '';
      }
    },      
    nextSlide() {
      this.moveSlide(1);
    },
    prevSlide() {
      this.moveSlide(-1);
    },
    moveSlide(direction) {
      this.currentIndex += direction;
      if (this.currentIndex >= this.productItems.length) {
        setTimeout(() => {
          this.currentIndex = 0;
          this.resetTransition();
        }, 500);
      } else if (this.currentIndex < 0) {
        this.currentIndex = this.productItems.length - 1;
        this.resetTransition(true);
      }
    },
    resetTransition(immediate = false) {
      this.$nextTick(() => {
        const content = this.$el.querySelector('.carousel-content');
        content.style.transition = 'none';
        content.style.transform = `translateX(${-this.currentIndex * 260}px)`;
        if (!immediate) {
          setTimeout(() => {
            content.style.transition = 'transform 0.5s ease';
          }, 50);
        } else {
          setTimeout(() => {
            content.style.transition = 'transform 0.5s ease';
            this.currentIndex--;
          }, 50);
        }
      });
    },
    onDragStart(e) {
      this.isDragging = true;
      this.dragStartX = e.type.startsWith('mouse') ? e.clientX : e.touches[0].clientX;
      this.$el.querySelector('.carousel-content').style.transition = 'none';
      this.pauseAutoplay();
    },
    onDragMove(e) {
      if (!this.isDragging) return;
      const currentX = e.type.startsWith('mouse') ? e.clientX : e.touches[0].clientX;
      this.dragOffset = currentX - this.dragStartX;
    },
    onDragEnd() {
      if (!this.isDragging) return;
      this.isDragging = false;
      this.$el.querySelector('.carousel-content').style.transition = 'transform 0.5s ease';
      if (Math.abs(this.dragOffset) > 50) {
        if (this.dragOffset > 0) {
          this.prevSlide();
        } else {
          this.nextSlide();
        }
      } else {
        this.dragOffset = 0;
      }
      this.resumeAutoplay();
    },
    startAutoplay() {
      this.autoplayTimer = setInterval(() => {
        if (!this.isAutoplayPaused) {
          this.nextSlide();
        }
      }, this.autoplayInterval);
    },
    stopAutoplay() {
      clearInterval(this.autoplayTimer);
    },
    pauseAutoplay() {
      this.isAutoplayPaused = true;
    },
    resumeAutoplay() {
      this.isAutoplayPaused = false;
    },
    truncateText(text, length) {
      if (text.length <= length) return text;
      return text.slice(0, length) + '...';
    },
  }
}
</script>

<style scoped>
.carousel {
  display: flex;
  align-items: center;
  width: 100%;
  overflow: hidden;
  touch-action: pan-y;
  user-select: none;
}

.carousel-container {
  width: 1100px; /* 260px * 3 slides */
  overflow: hidden;
}

.carousel-content {
  display: flex;
  transition: transform 0.5s ease;
}

.product-slide {
  flex: 0 0 260px;
  height: 240px;
  padding: 0 10px;
  box-sizing: border-box;
}

.product-content {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
}

.product-content img {
  max-width: 100%;
  max-height: 60%;
  object-fit: contain;
}

button {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  width: 30px;
}
</style>