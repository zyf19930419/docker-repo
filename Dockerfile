FROM kevin8093/tf_obj_detection

# COCO API http://cocodataset.org/
RUN git clone https://github.com/cocodataset/cocoapi.git /tmp/coco 

#RUN pip3 install --upgrade pip

RUN pip install Cython
RUN pip3 install Cython
    
# Compile
RUN cd /tmp/coco/PythonAPI && make