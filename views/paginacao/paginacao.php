

<?php if (isset($this->_paginacion)): ?>

    <div class="text-center">

        <ul class="pager">
            <?php if (isset($this->_paginacion['primero'])): ?>

                <li> <a href="<?php echo $link . $this->_paginacion['primero']; ?>">&laquo;</a></li>

            <?php else: ?>

                <li class="disabled">&laquo;</li> 

            <?php endif; ?>



            <?php if (isset($this->_paginacion['anterior'])): ?>

                <li><a href="<?php echo $link . $this->_paginacion['anterior']; ?>">&laquo;&laquo;</a></li>

            <?php else: ?>

                <li class="disabled">&laquo;</li> 

            <?php endif; ?>


            <?php if (isset($this->_paginacion['rango'])): ?>
                <?php for ($i = 0; $i < count($this->_paginacion['rango']); $i++): ?>

                    <?php if ($this->_paginacion['actual'] == $this->_paginacion['rango'][$i]): ?>

                        <li class="active"> <span><?php echo $this->_paginacion['rango'][$i]; ?></span></li>

                    <?php else: ?>

                        <a class="active" href="<?php echo $link . $this->_paginacion['rango'][$i]; ?>">
                            <?php echo $this->_paginacion['rango'][$i]; ?>
                        </a>&nbsp;

                    <?php endif; ?>

                <?php endfor; ?>
            <?php endif; ?>        




            <?php if (isset($this->_paginacion['siguiente'])): ?>

                <li><a href="<?php echo $link . $this->_paginacion['siguiente']; ?>">&raquo;&raquo;</a></li>

            <?php else: ?>

                <li class="disabled">&laquo;</li> 

            <?php endif; ?>



            <?php if (isset($this->_paginacion['ultimo'])): ?>

                <li><a href="<?php echo $link . $this->_paginacion['ultimo']; ?>">&raquo;</a></li>

            <?php else: ?>

                <li class="disabled">&laquo;</li> 

            <?php endif; ?>

        <?php endif; ?>


    </ul>
</div>

