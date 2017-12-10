FROM tensorflow/tensorflow:1.4.0-py3

#usage: 
#docker run -it -v ~/Workspace/tf_model/notebooks:/notebooks -p 8888:8888 -p 6006:6006 kevin8093/tf_sonnet_talib

#using China mirror for ubuntu
RUN sed -i 's/http:\/\/archive\.ubuntu\.com\/ubuntu\//http:\/\/mirrors\.163\.com\/ubuntu\//g' /etc/apt/sources.list

#sonnet
RUN pip3 install dm-sonnet && \
#----------------------------------------------------------------------------------------
#TA-LIB
    apt-get update && \
    apt-get install -y git  wget && \
    wget http://prdownloads.sourceforge.net/ta-lib/ta-lib-0.4.0-src.tar.gz && \
    tar -xvzf ta-lib-0.4.0-src.tar.gz && \
    cd ta-lib/ && \
    ./configure --prefix=/usr && \
    make && \
    make install && \
    git clone https://github.com/mrjbq7/ta-lib.git /tmp/ta-lib-py && \
    cd /tmp/ta-lib-py && python setup.py install && \
#seaborn install
    pip3 install seaborn && \
#----------------------------------------------------------------------------------------
#required by rqalpha
    apt-get install -y language-pack-en && \
    locale-gen en_US.UTF-8 && \
    dpkg-reconfigure locales

ENV LC_ALL=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV LANGUAGE=en_US.UTF-8
#rqalpha
RUN pip install -U pip setuptools cython -i https://pypi.tuna.tsinghua.edu.cn/simple && \
    pip install bcolz -i https://pypi.tuna.tsinghua.edu.cn/simple && \
    pip install -i https://pypi.tuna.tsinghua.edu.cn/simple rqalpha && \
    rqalpha update_bundle && \
#----------------------------------------------------------------------------------------
    pip3 install --no-cache-dir mock grpcio && \
    rm -rf /tmp/* && \
#----------------------------------------------------------------------------------------
#mysql support
    apt-get update && \
    apt-get install -y python-dev libmysqlclient-dev && \
    pip3 install --no-cache-dir mysqlclient && \
    pip3 install --no-cache-dir SQLAlchemy && \
#----------------------------------------------------------------------------------------
#beautiful soap
    pip3 install --no-cache-dir beautifulsoup4 && \
    pip3 install --no-cache-dir apscheduler

RUN pip3 install --no-cache-dir lxml && \
    pip3 install --no-cache-dir Tushare 

#update config file of Jupyter, it depends on your local configuration
RUN echo "from IPython.lib import passwd" \
         "\nc.NotebookApp.ip = '*'" \
         "\nc.NotebookApp.open_browser = False" \
         "\nc.NotebookApp.password = passwd('YourPassword')" \
         > /root/.jupyter/jupyter_notebook_config.py

RUN cd /root/.jupyter && mkdir nbconfig && \
    echo "{" \
         "  "Editor": {" \
         "      "codemirror_options": {" \
         "          "indentUnit": 4," \
         "          "vimMode": false," \
         "          "keyMap": "sublime"" \
         "      }" \
         "  }" \
         "}" \
         > /root/.jupyter/nbconfig/edit.json